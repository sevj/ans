<?php

namespace Adimeo\Notifications\Entity;

/**
 * Interface NotificationInterface
 * @package Adimeo\Notifications\Entity
 */
interface NotificationInterface
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
