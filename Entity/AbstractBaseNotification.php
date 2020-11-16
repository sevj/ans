<?php

namespace Adimeo\Notifications\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Class AbstractBaseNotification
 * @package Adimeo\Notifications\Entity
 */
abstract class AbstractBaseNotification implements NotificationInterface
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
     *
     * @Groups({"notification"})
     */
    protected $id;

    /**
     * @var string $user
     *
     * @ORM\Column(type="string", nullable=false)
     *
     * @Groups({"notification"})
     */
    protected $user;

    /**
     * @var \DateTime $date
     *
     * @ORM\Column(type="datetime", nullable=false)
     *
     * @Groups({"notification"})
     */
    protected $date;

    /**
     * @var int $type
     *
     * @ORM\Column(type="integer", nullable=false, options={"default": 1})
     *
     * @Groups({"notification"})
     */
    protected $type = self::TYPE_DEFAULT;

    /**
     * @var int $state
     *
     * @ORM\Column(type="integer", nullable=false, options={"default": 1})
     *
     * @Groups({"notification"})
     */
    protected $state = self::STATE_UNREAD;

    /**
     * @var array
     *
     * @ORM\Column(type="json", nullable=false)
     *
     * @Groups({"notification"})
     */
    protected $content;

    /**
     * AbstractBasicNotification constructor.
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
     * @return AbstractBaseNotification
     */
    public function setId(string $id): AbstractBaseNotification
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
     * @return AbstractBaseNotification
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
     * @return AbstractBaseNotification
     */
    public function setDate(\DateTime $date): AbstractBaseNotification
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
     * @return AbstractBaseNotification
     */
    public function setType(int $type): AbstractBaseNotification
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
     * @return AbstractBaseNotification
     */
    public function setState(int $state): AbstractBaseNotification
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
     * @return AbstractBaseNotification
     */
    public function setContent(array $content): AbstractBaseNotification
    {
        $this->content = $content;
        return $this;
    }
}
