<?php

namespace Adimeo\Notifications\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

//use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class Notification
 * @package Adimeo\Notifications\Entity
 */
abstract class AbstractNotification implements NotificationInterface
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
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $user;

    /**
     * @var \DateTime $date
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $date;

    /**
     * @var int $type
     *
     * @ORM\Column(type="integer", nullable=false, options={"default": 1})
     */
    protected $type = self::TYPE_DEFAULT;

    /**
     * @var int $state
     *
     * @ORM\Column(type="integer", nullable=false, options={"default": 1})
     */
    protected $state = self::STATE_UNREAD;

    /**
     * @var array
     *
     * @ORM\Column(type="json", nullable=false)
     */
    protected $content;

    /**
     * AbstractNotification constructor.
     * @param UserInterface $user
     * @param array $content
     */
    public function __construct(UserInterface $user, array $content)
    {
        $this->user     = $user;
        $this->content  = $content;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return AbstractNotification
     */
    public function setId(string $id): AbstractNotification
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     * @return AbstractNotification
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
     * @return AbstractNotification
     */
    public function setDate(\DateTime $date): AbstractNotification
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
     * @return AbstractNotification
     */
    public function setType(int $type): AbstractNotification
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
     * @return AbstractNotification
     */
    public function setState(int $state): AbstractNotification
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return array
     */
    public function getContent(): array
    {
        return $this->content;
    }

    /**
     * @param array $content
     * @return AbstractNotification
     */
    public function setContent(array $content): AbstractNotification
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->content;
    }
}
