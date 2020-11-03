<?php

namespace Adimeo\Notifications\Event;

use Adimeo\Notifications\Entity\AbstractNotification;

/**
 * Class NotificationEvent
 * @package Adimeo\Notifications\Event
 */
class NotificationEvent
{
    protected $notification;

    public function __construct(AbstractNotification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * @return AbstractNotification
     */
    public function getNotification(): AbstractNotification
    {
        return $this->notification;
    }
}
