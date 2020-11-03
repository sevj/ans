<?php

namespace Adimeo\Notifications\Message\Notification;

use Adimeo\Notifications\Entity\AbstractNotification;
use Adimeo\Notifications\Entity\NotificationInterface;
use Adimeo\Notifications\Message\NotificationMessageInterface;

/**
 * Class UserNotification
 * @package Adimeo\Notifications\Message\Notification
 */
class UserNotification implements NotificationMessageInterface
{
    /** @var AbstractNotification */
    protected $notification;

    /**
     * UserDocumentNotification constructor.
     * @param AbstractNotification $notification
     */
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
