<?php

namespace Adimeo\Notifications\Message\Notification;

use Adimeo\Notifications\Entity\NotificationInterface;
use Adimeo\Notifications\Message\NotificationMessageInterface;

/**
 * Class UserNotification
 * @package Adimeo\Notifications\Message\Notification
 */
class UserNotification implements NotificationMessageInterface
{
    /** @var NotificationInterface */
    protected $notification;

    /**
     * UserDocumentNotification constructor.
     * @param NotificationInterface $notification
     */
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
