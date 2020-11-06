<?php

namespace Adimeo\Notifications\Entity;

/**
 * Interface NotificationInterface
 * @package Adimeo\Notifications\Entity
 */
interface NotificationInterface
{
    public static function getTargetedEntity(): string;

    public function getData(): array;
}
