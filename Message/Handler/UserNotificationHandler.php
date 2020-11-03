<?php

namespace Adimeo\Notifications\Message\Handler;

use Adimeo\Notifications\Manager\NotificationManager;
use Adimeo\Notifications\Message\Notification\UserNotification;

/**
 * Class UserNotificationHandler
 * @package App\Message\Handler
 */
class UserNotificationHandler implements MessageHandlerInterface
{
    /**
     * @var NotificationManager $notificationManager
     */
    protected $notificationManager;

    /**
     * UserNotificationHandler constructor.
     * @param NotificationManager $notificationManager
     */
    public function __construct(
        NotificationManager $notificationManager
    ) {
        $this->notificationManager = $notificationManager;
    }

    /**
     * @param UserNotification $message
     */
    public function __invoke(UserNotification $message)
    {
        $notification = $message->getNotification();


    }
}
