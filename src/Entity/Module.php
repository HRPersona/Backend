<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Core\Logger\ActionLoggerAwareInterface;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Core\Security\Model\ModuleInterface;
use Persona\Hris\Core\Security\Model\ServiceInterface;
use Persona\Hris\Core\Util\StringUtil;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="c_modules", indexes={
 *     @ORM\Index(name="module_search_idx", columns={"path", "name"}),
 *     @ORM\Index(name="module_search_idx_path", columns={"path"}),
 *     @ORM\Index(name="module_search_idx_name", columns={"name"})
 * })
 *
 * @ApiResource(
 *     attributes={
 *         "filters"={"order.filter", "name.search", "service.search"},
 *         "normalization_context"={"groups"={"read"}},
 *         "denormalization_context"={"groups"={"write"}}
 *     }
 * )
 *
 * @UniqueEntity("name")
 * @UniqueEntity("path")
 *
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
class Module implements ModuleInterface, ActionLoggerAwareInterface
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
     * @Groups({"write", "read"})
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\Service", fetch="EAGER")
     * @ORM\JoinColumn(name="service_id", referencedColumnName="id")
     * @Assert\NotBlank()
     *
     * @var ServiceInterface
     */
    private $service;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $name;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $groupName;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     *
     * @var int
     */
    private $menuOrder;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    private $menuDisplay;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    private $description;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $iconCls;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $path;

    public function __construct()
    {
        $this->iconCls = 'windows';
        $this->menuDisplay = true;
        $this->menuOrder = 1;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return (string) $this->id;
    }

    /**
     * @return ServiceInterface
     */
    public function getService(): ? ServiceInterface
    {
        return $this->service;
    }

    /**
     * @param ServiceInterface $service
     */
    public function setService(ServiceInterface $service = null): void
    {
        $this->service = $service;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = StringUtil::uppercase($name);
    }

    /**
     * @return string
     */
    public function getGroupName(): string
    {
        return (string) $this->groupName;
    }

    /**
     * @param string $groupName
     */
    public function setGroupName(string $groupName)
    {
        $this->groupName = StringUtil::uppercase($groupName);
    }

    /**
     * @return int
     */
    public function getMenuOrder(): int
    {
        return $this->menuOrder ?? 1;
    }

    /**
     * @param int $menuOrder
     */
    public function setMenuOrder(int $menuOrder)
    {
        $this->menuOrder = $menuOrder;
    }

    /**
     * @return bool
     */
    public function isMenuDisplay(): bool
    {
        return $this->menuDisplay ?? false;
    }

    /**
     * @param bool $menuDisplay
     */
    public function setMenuDisplay(bool $menuDisplay)
    {
        $this->menuDisplay = $menuDisplay;
    }

    /**
     * @return string
     */
    public function getDescription(): ? string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getIconCls(): string
    {
        return (string) $this->iconCls;
    }

    /**
     * @param string $iconCls
     */
    public function setIconCls(string $iconCls)
    {
        $this->iconCls = StringUtil::lowercase($iconCls);
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath(string $path)
    {
        $this->path = StringUtil::lowercase($path);
    }
}
