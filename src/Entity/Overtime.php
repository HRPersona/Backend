<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Core\Logger\ActionLoggerAwareInterface;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Overtime\Model\EmployeeOvertimeInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="ov_overtimes")
 *
 * @ApiResource(
 *     attributes={
 *         "filters"={"order.filter"},
 *         "normalization_context"={"groups"={"read"}},
 *         "denormalization_context"={"groups"={"write"}}
 *     }
 * )
 *
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
class Overtime implements EmployeeOvertimeInterface, ActionLoggerAwareInterface
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
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\Employee", fetch="EAGER")
     * @ORM\JoinColumn(name="employee_id", referencedColumnName="id")
     * @Assert\NotBlank()
     *
     * @var EmployeeInterface
     */
    private $employee;

    /**
     * @Groups({"read", "write"})
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\Employee", fetch="EAGER")
     * @ORM\JoinColumn(name="proposed_by_id", referencedColumnName="id")
     * @Assert\NotBlank()
     *
     * @var EmployeeInterface
     */
    private $proposedBy;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     *
     * @var \DateTime
     */
    private $overtimeDate;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="float", scale=27, precision=2)
     * @Assert\NotBlank()
     *
     * @var float
     */
    private $overtimeValue;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    private $offTime;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $remark;

    public function __construct()
    {
        $this->offTime = false;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return EmployeeInterface
     */
    public function getEmployee(): EmployeeInterface
    {
        return $this->employee;
    }

    /**
     * @param EmployeeInterface $employee
     */
    public function setEmployee(EmployeeInterface $employee = null): void
    {
        $this->employee = $employee;
    }

    /**
     * @return EmployeeInterface
     */
    public function getProposedBy(): EmployeeInterface
    {
        return $this->proposedBy;
    }

    /**
     * @param EmployeeInterface $proposedBy
     */
    public function setProposedBy(EmployeeInterface $proposedBy = null): void
    {
        $this->proposedBy = $proposedBy;
    }

    /**
     * @return \DateTime
     */
    public function getOvertimeDate(): \DateTime
    {
        return $this->overtimeDate;
    }

    /**
     * @param \DateTime $overtimeDate
     */
    public function setOvertimeDate(\DateTime $overtimeDate)
    {
        $this->overtimeDate = $overtimeDate;
    }

    /**
     * @return float
     */
    public function getOvertimeValue(): float
    {
        return $this->overtimeValue;
    }

    /**
     * @param float $overtimeValue
     */
    public function setOvertimeValue(float $overtimeValue)
    {
        $this->overtimeValue = $overtimeValue;
    }

    /**
     * @return bool
     */
    public function isOffTime(): bool
    {
        return $this->offTime;
    }

    /**
     * @param bool $offTime
     */
    public function setOffTime(bool $offTime)
    {
        $this->offTime = $offTime;
    }

    /**
     * @return string
     */
    public function getRemark(): string
    {
        return $this->remark;
    }

    /**
     * @param string $remark
     */
    public function setRemark(string $remark)
    {
        $this->remark = $remark;
    }
}
