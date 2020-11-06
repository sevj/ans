<?php

namespace Adimeo\Notifications\Services;

use Adimeo\Notifications\Entity\AbstractNotification;
use Adimeo\Notifications\Entity\NotificationInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;

/**
 * Class NotificationManager
 * @package Adimeo\Notifications\Services
 */
class NotificationManager
{
    protected $publisher;
    protected $entityManager;

    public function __construct(
        PublisherInterface $publisher,
        EntityManagerInterface $entityManager
    ) {
        $this->entityManager = $entityManager;
        $this->publisher = $publisher;
    }

    public function create(NotificationInterface $notification, bool $publish = true)
    {
        $notification
            ->setDate(new \DateTime())
        ;

        $user = $notification->getUser();
        $user = $this->entityManager->find($notification::getTargetedEntity(), $user->getId());
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
     */
    public function publish(NotificationInterface $notification)
    {
        $update = new Update(
            $this->buildUpdateTopic($notification),
            json_encode($notification->getContent())
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
            'notifications/%s/%s/notification',
            get_class($notification),
            $notification->getUser()->getId()
        );
    }
}
