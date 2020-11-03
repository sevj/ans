<?php

namespace Adimeo\Notifications\Manager;

use Adimeo\Notifications\Entity\AbstractNotification;
use Adimeo\Notifications\Entity\NotificationInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class NotificationManager
 * @package Adimeo\Notifications\Manager
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

    public function create(string $fqcn, UserInterface $user, array $content, bool $publish = true)
    {
        /** @var NotificationInterface $notification */
        $notification = (new $fqcn())
            ->setUser($user)
            ->setTarget(get_class($user))
            ->setDate(new \DateTime())
            ->setContent($content)
        ;

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
