<?php

namespace Adimeo\Notifications\Services;

use Adimeo\Notifications\Entity\NotificationInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mercure\PublisherInterface;

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

    public function publish(NotificationInterface $notification)
    {

    }
}
