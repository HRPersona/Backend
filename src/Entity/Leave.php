<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Attendance\Model\AbsentReasonInterface;
use Persona\Hris\Core\Logger\ActionLoggerAwareInterface;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Core\Util\StringUtil;
use Persona\Hris\Leave\Model\LeaveInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="lv_leaves", indexes={
 *     @ORM\Index(name="leave_search_idx", columns={"code", "name"}),
 *     @ORM\Index(name="leave_search_idx_code", columns={"code"}),
 *     @ORM\Index(name="leave_search_idx_name", columns={"name"})
 * })
 *
 * @ApiResource(
 *     attributes={
 *         "filters"={"order.filter", "code.search", "name.search"},
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
class Leave implements LeaveInterface, ActionLoggerAwareInterface
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
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\AbsentReason", fetch="EAGER")
     * @ORM\JoinColumn(name="employee_id", referencedColumnName="id")
     * @Assert\NotBlank()
     *
     * @var AbsentReasonInterface
     */
    private $absentReason;

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
     * @Groups({"read", "write"})
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $dayBenefit;

    public function __construct()
    {
        $this->dayBenefit = 0;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return AbsentReasonInterface
     */
    public function getAbsentReason(): AbsentReasonInterface
    {
        return $this->absentReason;
    }

    /**
     * @param AbsentReasonInterface $absentReason
     */
    public function setAbsentReason(AbsentReasonInterface $absentReason = null): void
    {
        $this->absentReason = $absentReason;
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

    /**
     * @return int
     */
    public function getDayBenefit(): int
    {
        return $this->dayBenefit;
    }

    /**
     * @param int $dayBenefit
     */
    public function setDayBenefit(int $dayBenefit)
    {
        $this->dayBenefit = $dayBenefit;
    }
}
