<?php

namespace Adimeo\Notifications\Message\Notification;

use Adimeo\Notifications\Entity\AbstractNotification;
use Adimeo\Notifications\Message\NotificationMessageInterface;

/**
 * Class UserNotification
 * @package Adimeo\Notifications\Message\Notification
 */
class UserNotification implements NotificationMessageInterface
{
    /** @var AbstractNotification */
    protected $notification;
    protected $publish;

    /**
     * UserNotification constructor.
     * @param AbstractNotification $notification
     * @param bool $publish
     */
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
