<?php

namespace Adimeo\Notifications\Event;

use Adimeo\Notifications\Entity\NotificationInterface;

/**
 * Class NotificationEvent
 * @package Adimeo\Notifications\Event
 */
class NotificationEvent
{
    protected $notification;

    public function __construct(NotificationInterface $notification)
    {
        $this->notification = $notification;
    }

    /**
     * @return NotificationInterface
     */
    public function getNotification(): NotificationInterface
    {
        return $this->notification;
    }
}
