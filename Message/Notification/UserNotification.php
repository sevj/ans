<?php

namespace Adimeo\Notifications\Message\Notification;

use Adimeo\Notifications\Entity\AbstractBasicNotification;
use Adimeo\Notifications\Entity\BaseNotificationInterface;
use Adimeo\Notifications\Message\NotificationMessageInterface;

/**
 * Class UserNotification
 * @package Adimeo\Notifications\Message\Notification
 */
class UserNotification implements NotificationMessageInterface
{
    /** @var BaseNotificationInterface */
    protected $notification;
    protected $publish;

    /**
     * UserNotification constructor.
     * @param BaseNotificationInterface $notification
     * @param bool $publish
     */
    public function __construct(BaseNotificationInterface $notification, $publish = true)
    {
        $this->notification = $notification;
        $this->publish = $publish;
    }

    /**
     * @return BaseNotificationInterface
     */
    public function getNotification(): BaseNotificationInterface
    {
        return $this->notification;
    }

    public function toPublish()
    {
        return $this->publish;
    }
}
