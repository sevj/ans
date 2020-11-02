<?php

namespace Adimeo\Notifications\Entity;

use Doctrine\ORM\Mapping as ORM;
//use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class Notification
 * @package Adimeo\Notifications\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="ans_notifications")
 * @ORM\Entity(repositoryClass="Adimeo\Notifications\Repository\NotificationRepository")
 *
 */
class Notification
{
    const TYPE_DEFAULT = 1;

    const STATE_UNREAD = 1;
    const STATE_READ   = 2;

    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    protected $id;

    /**
     * @var string $user
     */
    protected $user;

    /**
     * @var \DateTime $date
     */
    protected $date;

    /**
     * @var int $type
     */
    protected $type = self::TYPE_DEFAULT;

    /**
     * @var int $state
     */
    protected $state = self::STATE_UNREAD;

    /**
     * @var string
     */
    protected $content;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Notification
     */
    public function setId(string $id): Notification
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return Notification
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return Notification
     */
    public function setDate(\DateTime $date): Notification
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     * @return Notification
     */
    public function setType(int $type): Notification
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return int
     */
    public function getState(): int
    {
        return $this->state;
    }

    /**
     * @param int $state
     * @return Notification
     */
    public function setState(int $state): Notification
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return Notification
     */
    public function setContent(string $content): Notification
    {
        $this->content = $content;
        return $this;
    }
}
