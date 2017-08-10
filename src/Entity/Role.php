<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Core\Logger\Model\ActionLoggerAwareInterface;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Core\Security\Model\ModuleAwareInterface;
use Persona\Hris\Core\Security\Model\ModuleInterface;
use Persona\Hris\Core\Security\Model\RoleInterface;
use Persona\Hris\Core\Security\Model\UserAwareInterface;
use Persona\Hris\Core\Security\Model\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="c_roles", indexes={
 *     @ORM\Index(name="client_search_idx", columns={"module_id", "user_id"}),
 *     @ORM\Index(name="client_search_idx_module", columns={"module_id"}),
 *     @ORM\Index(name="client_search_idx_user", columns={"user_id"})
 * })
 *
 * @ApiResource(
 *     collectionOperations={
 *         "get"={"method"="GET"},
 *         "post"={"method"="POST"}
 *     },
 *     attributes={
 *         "filters"={
 *             "user.search",
 *             "module.search",
 *             "menu_display.search"
 *         },
 *         "normalization_context"={"groups"={"read"}},
 *         "denormalization_context"={"groups"={"write"}}
 *     }
 * )
 *
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
class Role implements RoleInterface, ModuleAwareInterface, UserAwareInterface, ActionLoggerAwareInterface
{
    use ActionLoggerAwareTrait;
    use Timestampable;
    use SoftDeletable;

    /**
     * @Groups({"read"})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid")
     *
     * @var string
     */
    private $id;

    /**
     * @Groups({"write"})
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $userId;

    /**
     * @var UserInterface
     */
    private $user;

    /**
     * @Groups({"write", "read"})
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $moduleId;

    /**
     * @var ModuleInterface
     */
    private $module;

    /**
     * @Groups({"write", "read"})
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    private $addable;

    /**
     * @Groups({"write", "read"})
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    private $editable;

    /**
     * @Groups({"write", "read"})
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    private $viewable;

    /**
     * @Groups({"write", "read"})
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    private $deletable;

    public function __construct()
    {
        $this->addable = false;
        $this->editable = false;
        $this->viewable = false;
        $this->deletable = false;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return (string) $this->id;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return (string) $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId(string $userId = null)
    {
        $this->userId = $userId;
    }

    /**
     * @return UserInterface
     */
    public function getUser(): UserInterface
    {
        return $this->user;
    }

    /**
     * @param UserInterface $user
     */
    public function setUser(UserInterface $user = null): void
    {
        $this->user = $user;
        if ($user) {
            $this->userId = $user->getId();
        }
    }

    /**
     * @return string
     */
    public function getModuleId(): string
    {
        return (string) $this->moduleId;
    }

    /**
     * @param string $moduleId
     */
    public function setModuleId(string $moduleId = null)
    {
        $this->moduleId = $moduleId;
    }

    /**
     * @return ModuleInterface
     */
    public function getModule(): ? ModuleInterface
    {
        return $this->module;
    }

    /**
     * @param ModuleInterface $module
     */
    public function setModule(ModuleInterface $module = null): void
    {
        $this->module = $module;
        if ($module) {
            $this->moduleId = $module->getId();
        }
    }

    /**
     * @return bool
     */
    public function getAddable(): bool
    {
        return $this->addable;
    }

    /**
     * @param bool $addable
     */
    public function setAddable(bool $addable)
    {
        $this->addable = $addable;
    }

    /**
     * @return bool
     */
    public function getEditable(): bool
    {
        return $this->editable;
    }

    /**
     * @param bool $editable
     */
    public function setEditable(bool $editable)
    {
        $this->editable = $editable;
    }

    /**
     * @return bool
     */
    public function getViewable(): bool
    {
        return $this->viewable;
    }

    /**
     * @param bool $viewable
     */
    public function setViewable(bool $viewable)
    {
        $this->viewable = $viewable;
    }

    /**
     * @return bool
     */
    public function getDeletable(): bool
    {
        return $this->deletable;
    }

    /**
     * @param bool $deletable
     */
    public function setDeletable(bool $deletable)
    {
        $this->deletable = $deletable;
    }
}
