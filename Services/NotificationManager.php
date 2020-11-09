<?php

namespace Adimeo\Notifications\Services;

use Adimeo\Notifications\Entity\AbstractNotification;
use Adimeo\Notifications\Entity\NotificationInterface;
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
     * @param NotificationInterface $notification
     * @param bool $publish
     * @return NotificationInterface
     * @throws \Exception
     */
    public function create(NotificationInterface $notification, bool $publish = true)
    {
        $notification
            ->setDate(new \DateTime())
        ;

        $user = $this->entityManager->find($notification::getTargetedEntity(), $notification->getUserId());
        $notification->setUser($user);

        $this->entityManager->persist($notification);
        $this->entityManager->flush();

        if ($publish) {
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
     */
    public function read(string $entity, string $id)
    {
        /** @var AbstractNotification $notification */
        $notification = $this->entityManager->getRepository($entity)->find($id);

        $notification->setState(AbstractNotification::STATE_READ);

        $this->entityManager->persist($notification);
        $this->entityManager->flush();
    }

    /**
     * @param NotificationInterface $notification
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function publish(NotificationInterface $notification)
    {
        $update = new Update(
            $this->buildUpdateTopic($notification),
            $this->buildContent($notification)
        );

        $this->publisher->__invoke($update);
    }

    /**
     * @param NotificationInterface $notification
     * @return string
     */
    protected function buildUpdateTopic(NotificationInterface $notification): string
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
     * @param NotificationInterface $notification
     * @return string
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    protected function buildContent(NotificationInterface $notification): string
    {
        return json_encode([
            'notification' => $this->normalizer->normalize($notification, null, [
                'groups' => ['notification'],
            ])
        ]);
    }
}
