<?php

namespace Adimeo\Notifications\Entity;

/**
 * Interface NotificationInterface
 * @package Adimeo\Notifications\Entity
 */
interface NotificationInterface
{
    public function getTargetedEntity(): string;
}
