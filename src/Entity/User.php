<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Core\Logger\ActionLoggerAwareInterface;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Core\Security\Model\UserInterface;
use Persona\Hris\Core\Upload\UploadableInterface;
use Persona\Hris\Core\Util\StringUtil;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="c_users", indexes={@ORM\Index(name="user_search_idx", columns={"username", "email"})})
 *
 * @ApiResource(
 *     collectionOperations={
 *         "get"={"method"="GET"},
 *         "post"={"method"="POST"},
 *         "user_me"={"route_name"="user_me"},
 *         "update_profile"={"route_name"="update_profile"}
 *     },
 *     attributes={
 *         "validation_groups"={"Default"},
 *         "filters"={
 *             "order.filter",
 *             "username.search",
 *             "email.search"
 *         },
 *         "normalization_context"={"groups"={"read"}},
 *         "denormalization_context"={"groups"={"write"}}
 *     }
 * )
 *
 * @UniqueEntity("username")
 * @UniqueEntity("email")
 *
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
class User extends BaseUser implements UserInterface, UploadableInterface, ActionLoggerAwareInterface
{
    use ActionLoggerAwareTrait;
    use Timestampable;
    use SoftDeletable;

    /**
     * @Groups({"read", "write"})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid")
     *
     * @var string
     */
    protected $id;

    /**
     * @Groups({"read", "write"})
     * @Assert\NotBlank()
     * @Assert\Email()
     *
     * @var string
     */
    protected $email;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $fullName;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    private $profileImage;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="boolean", nullable=true)
     *
     * @var bool
     */
    private $loggedIn;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    private $sessionId;

    /**
     * @Groups({"write"})
     *
     * @var string
     */
    protected $plainPassword;

    /**
     * @Groups({"read", "write"})
     * @Assert\NotBlank()
     *
     * @var string
     */
    protected $username;

    /**
     * @Groups({"read"})
     *
     * @var array
     */
    protected $roles;

    /**
     * @Groups({"read", "write"})
     *
     * @var bool
     */
    protected $enabled;

    /**
     * @Groups({"write"})
     *
     * @var string
     */
    private $imageString;

    /**
     * @Groups({"write"})
     *
     * @var string
     */
    private $imageExtension;

    public function __construct()
    {
        parent::__construct();
        $this->loggedIn = false;
        $this->setEnabled(true);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**'
     * @param string $username
     *
     * @return $this|\FOS\UserBundle\Model\UserInterface|void
     */
    public function setUsername($username)
    {
        $this->username = StringUtil::lowercase($username);
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return (string) $this->fullName;
    }

    /**
     * @param string $fullName
     */
    public function setFullName(string $fullName)
    {
        $this->fullName = StringUtil::uppercase($fullName);
    }

    /**
     * @return null|string
     */
    public function getProfileImage(): ? string
    {
        if ($this->profileImage) {
            return sprintf('%s/%s', $this->getDirectoryPrefix(), $this->profileImage);
        }

        return 'default_avatar.png';
    }

    /**
     * @param string $profileImage
     */
    public function setProfileImage(string $profileImage)
    {
        $this->profileImage = $profileImage;
    }

    /**
     * @return bool
     */
    public function getLoggedIn(): bool
    {
        return null !== $this->loggedIn ? $this->loggedIn : false;
    }

    /**
     * @param UserInterface    $user
     * @param SessionInterface $session
     *
     * @return bool
     */
    public function isLoggedIn(UserInterface $user, SessionInterface $session): bool
    {
        return $this->getLoggedIn() && '' !== $user->getSessionId() && $user->getSessionId() !== $session->get(self::SESSION_KEY);
    }

    /**
     * @param bool $loggedIn
     */
    public function setLoggedIn(bool $loggedIn)
    {
        $this->loggedIn = $loggedIn;

        if (!$this->loggedIn) {
            $this->setSessionId('');
        }
    }

    /**
     * @return string
     */
    public function getSessionId(): string
    {
        return $this->sessionId ?: '';
    }

    /**
     * @param string $sessionId
     */
    public function setSessionId(string $sessionId)
    {
        $this->sessionId = $sessionId;
    }

    /**
     * @param UserInterface|null $user
     *
     * @return bool
     */
    public function isMe(UserInterface $user = null): bool
    {
        return $user instanceof self && $user->getId() === $this->getId();
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return [sprintf('ROLE_%s', strtoupper($this->getUsername()))];
    }

    /**
     * @return string
     */
    public function getImageString(): ? string
    {
        return $this->imageString;
    }

    /**
     * @param string $imageString
     */
    public function setImageString(string $imageString)
    {
        $this->imageString = $imageString;
    }

    /**
     * @return string
     */
    public function getImageExtension(): ? string
    {
        return $this->imageExtension;
    }

    /**
     * @param string $imageExtension
     */
    public function setImageExtension(string $imageExtension)
    {
        $this->imageExtension = $imageExtension;
        if ($imageExtension) {
            $this->profileImage = $imageExtension;
        }
    }

    /**
     * @return string
     */
    public function getTargetField(): string
    {
        return 'profileImage';
    }

    /**
     * @return string
     */
    public function getDirectoryPrefix(): string
    {
        return 'profiles';
    }
}
