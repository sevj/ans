<?php

namespace Adimeo\Notifications\Services;

use Adimeo\Notifications\Entity\AbstractNotification;
use Adimeo\Notifications\Entity\NotificationInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class NotificationManager
 * @package Adimeo\Notifications\Services
 */
class NotificationManager
{
    protected $entityManager;
    protected $publisher;

    public function __construct(
        EntityManagerInterface $entityManager,
        PublisherInterface $publisher
    ) {
        $this->entityManager = $entityManager;
        $this->publisher = $publisher;
    }

    public function create(AbstractNotification $notification, bool $publish = true)
    {
        $notification
            ->setDate(new \DateTime());

        $this->entityManager->persist($notification);
        $this->entityManager->flush();

        if ($publish) {
            $this->publish($notification);
        }

        return $notification;
    }

    public function publish(NotificationInterface $notification)
    {

    }
}
