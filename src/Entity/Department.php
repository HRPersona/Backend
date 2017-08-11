<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Core\Logger\Model\ActionLoggerAwareInterface;
use Persona\Hris\Core\Util\StringUtil;
use Persona\Hris\Organization\Model\DepartmentInterface;
use Persona\Hris\Organization\Model\ParentDepartmentAwareInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="og_departments", indexes={
 *     @ORM\Index(name="department_search_idx", columns={"parent_id", "code", "name"}),
 *     @ORM\Index(name="department_search_idx_parent", columns={"parent_id"}),
 *     @ORM\Index(name="department_search_idx_code", columns={"code"}),
 *     @ORM\Index(name="department_search_idx_name", columns={"name"})
 * })
 *
 * @ApiResource(
 *     attributes={
 *         "filters"={
 *             "order.filter",
 *             "code.search",
 *             "name.search"
 *         },
 *         "normalization_context"={"groups"={"read"}},
 *         "denormalization_context"={"groups"={"write"}}
 *     }
 * )
 *
 * @UniqueEntity("code")
 * @UniqueEntity("name")
 *
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
class Department implements DepartmentInterface, ParentDepartmentAwareInterface, ActionLoggerAwareInterface
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
     * @Groups({"read", "write"})
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $parentId;

    /**
     * @var DepartmentInterface
     */
    private $parent;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=7)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $code;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $name;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getParentId(): string
    {
        return (string) $this->parentId;
    }

    /**
     * @param string $parentId
     */
    public function setParentId(string $parentId = null)
    {
        $this->parentId = $parentId;
    }

    /**
     * @return DepartmentInterface
     */
    public function getParent(): ? DepartmentInterface
    {
        return $this->parent;
    }

    /**
     * @param DepartmentInterface $parent
     */
    public function setParent(DepartmentInterface $parent = null): void
    {
        $this->parent = $parent;
        if ($parent) {
            $this->parentId = $parent->getId();
        }
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code)
    {
        $this->code = StringUtil::uppercase($code);
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
}
