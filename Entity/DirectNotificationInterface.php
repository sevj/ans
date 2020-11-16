<?php

namespace Adimeo\Notifications\Entity;

/**
 * Interface DirectNotificationInterface
 * @package Adimeo\Notifications\Entity
 */
interface DirectNotificationInterface extends BaseNotificationInterface
{
    /**
     * @return bool
     */
    public function toPublish(): bool;
}
