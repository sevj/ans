<?php

namespace Adimeo\Notifications\Event;

use Adimeo\Notifications\Entity\DirectNotificationInterface;

/**
 * Class DirectNotificationEvent
 * @package Adimeo\Notifications\Event
 */
class DirectNotificationEvent
{
    protected $notification;
    protected $publish;

    public function __construct(DirectNotificationInterface $notification, $publish = true)
    {
        $this->notification = $notification;
        $this->publish = $publish;
    }

    /**
     * @return DirectNotificationInterface
     */
    public function getNotification(): DirectNotificationInterface
    {
        return $this->notification;
    }

    public function toPublish()
    {
        return $this->publish;
    }
}
