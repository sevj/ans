<?php


namespace Adimeo\Notifications\Entity;


interface BaseNotificationInterface
{
    /**
     * @return string
     */
    public function getUserId(): string;

    /**
     * @return string
     */
    public static function getTargetedEntity(): string;
}