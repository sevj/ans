<?php

namespace App\EventSubscriber;

use Adimeo\Notifications\Event\NotificationEvent;
use Adimeo\Notifications\Message\Notification\UserNotification;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class NotificationSubscriber
 * @package App\EventSubscriber
 */
final class NotificationSubscriber implements EventSubscriberInterface
{
    /** @var MessageBusInterface */
    protected $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            NotificationEvent::class => [
                ['sendNotification'],
            ],
        ];
    }

    public function sendNotification(NotificationEvent $event)
    {
        $this->bus->dispatch(new UserNotification($event));
    }
}
