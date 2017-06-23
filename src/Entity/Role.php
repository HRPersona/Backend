<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Core\Logger\ActionLoggerAwareInterface;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Core\Security\Model\ModuleInterface;
use Persona\Hris\Core\Security\Model\RoleInterface;
use Persona\Hris\Core\Security\Model\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity()
 * @ORM\Table(name="c_roles")
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
class Role implements RoleInterface, ActionLoggerAwareInterface
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
    private $id;

    /**
     * @Groups({"write"})
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\User", fetch="EAGER")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     * @var UserInterface
     */
    private $user;

    /**
     * @Groups({"write", "read"})
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\Module", fetch="EAGER")
     * @ORM\JoinColumn(name="module_id", referencedColumnName="id")
     *
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
     * @return UserInterface|null
     */
    public function getUser(): ? UserInterface
    {
        return $this->user;
    }

    /**
     * @param UserInterface $user
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;
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
    public function setModule(ModuleInterface $module): void
    {
        $this->module = $module;
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
