<?php

namespace Adimeo\Notifications\Services;

use Adimeo\Notifications\Entity\AbstractBaseNotification;
use Adimeo\Notifications\Entity\BaseNotificationInterface;
use Adimeo\Notifications\Entity\DirectNotificationInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class NotificationManager
 * @package Adimeo\Notifications\Services
 */
class NotificationManager
{
    /** @var PublisherInterface  */
    protected $publisher;

    /** @var EntityManagerInterface  */
    protected $entityManager;

    /** @var NormalizerInterface */
    protected $normalizer;

    /**
     * NotificationManager constructor.
     * @param PublisherInterface $publisher
     * @param EntityManagerInterface $entityManager
     * @param NormalizerInterface $normalizer
     */
    public function __construct(
        PublisherInterface $publisher,
        EntityManagerInterface $entityManager,
        NormalizerInterface $normalizer
    ) {
        $this->entityManager = $entityManager;
        $this->publisher = $publisher;
        $this->normalizer = $normalizer;
    }

    /**
     * @param BaseNotificationInterface $notification
     * @return BaseNotificationInterface
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function create(BaseNotificationInterface $notification)
    {
        $notification
            ->setDate(new \DateTime())
        ;

        $user = $this->entityManager->find($notification::getTargetedEntity(), $notification->getUserId());
        $notification->setUser($user);

        $this->entityManager->persist($notification);
        $this->entityManager->flush();

        if ($notification instanceof DirectNotificationInterface && $notification->toPublish()) {
            $this->publish($notification);
        }

        return $notification;
    }

    /**
     * @param string $entity
     * @param string $id
     * @param int $page
     * @param int $limit
     * @param array $orderBy
     * @return object[]
     */
    public function fetchForOneUser(
        string $entity,
        string $id,
        int $page = 1,
        int $limit = 10,
        array $orderBy = ['date' => 'DESC']
    ) {
        return $this->entityManager->getRepository($entity)->findBy([
            'user' => $id
        ], $orderBy, $limit, ($page - 1) * $limit);
    }

    /**
     * @param string $entity
     * @param string $id
     * @return bool
     */
    public function hasUnread(
        string $entity,
        string $id
    ) {
        return count($this->entityManager->getRepository($entity)->findBy([
                'user' => $id,
                'state' => AbstractBaseNotification::STATE_UNREAD
            ])) > 0;
    }

    /**
     * @param string $entity
     * @param string $id
     */
    public function read(string $entity, string $id): void
    {
        /** @var AbstractBaseNotification $notification */
        $notification = $this->entityManager->getRepository($entity)->find($id);

        $notification->setState(AbstractBaseNotification::STATE_READ);

        $this->entityManager->persist($notification);
        $this->entityManager->flush();
    }

    /**
     * @param string $entity
     * @param string $id
     */
    public function readAllUserNotifications(string $entity, string $id): void
    {
        $notifications = $this->entityManager->getRepository($entity)->findBy([
            'user' => $id,
            'state' => AbstractBaseNotification::STATE_UNREAD
        ]);

        /** @var AbstractBaseNotification $notification */
        foreach ($notifications as $notification) {
            $notification->setState(AbstractBaseNotification::STATE_READ);
            $this->entityManager->persist($notification);
        }

        $this->entityManager->flush();
    }

    /**
     * @param DirectNotificationInterface $notification
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function publish(DirectNotificationInterface $notification)
    {
        $update = new Update(
            $this->buildUpdateTopic($notification),
            $this->buildContent($notification)
        );

        $this->publisher->__invoke($update);
    }

    /**
     * @param DirectNotificationInterface $notification
     * @return string
     */
    protected function buildUpdateTopic(DirectNotificationInterface $notification): string
    {
        $id = $notification->getId();
        if (null === $id) {
            throw new \InvalidArgumentException();
        }

        return sprintf(
            'notifications-%s-%s',
            get_class($notification),
            $notification->getUser()->getId()
        );
    }

    /**
     * @param DirectNotificationInterface $notification
     * @return string
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    protected function buildContent(DirectNotificationInterface $notification): string
    {
        return json_encode([
            'notification' => $this->normalizer->normalize($notification, null, [
                'groups' => ['notification'],
            ])
        ]);
    }
}
