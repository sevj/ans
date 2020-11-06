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
    protected $publish;

    public function __construct(AbstractNotification $notification, $publish = true)
    {
        $this->notification = $notification;
        $this->publish = $publish;
    }

    /**
     * @return AbstractNotification
     */
    public function getNotification(): AbstractNotification
    {
        return $this->notification;
    }

    public function toPublish()
    {
        return $this->publish;
    }
}
