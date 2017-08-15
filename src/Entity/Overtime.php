<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Core\Logger\Model\ActionLoggerAwareInterface;
use Persona\Hris\Employee\Model\EmployeeAwareInterface;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Employee\Model\ProposedByAwareInterface;
use Persona\Hris\Overtime\Model\EmployeeOvertimeInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="ov_overtimes", indexes={
 *     @ORM\Index(name="overtime_search_idx", columns={"employee_id", "proposed_by_id"}),
 *     @ORM\Index(name="overtime_search_employee_id", columns={"employee_id"}),
 *     @ORM\Index(name="overtime_search_proposed_by", columns={"proposed_by_id"})
 * })
 *
 * @ApiResource(
 *     attributes={
 *         "filters"={"order.filter"},
 *         "normalization_context"={"groups"={"read"}},
 *         "denormalization_context"={"groups"={"write"}}
 *     },
 *     collectionOperations={"get"={"method"="GET"}},
 *     itemOperations={"get"={"method"="GET"}}
 * )
 *
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
class Overtime implements EmployeeOvertimeInterface, EmployeeAwareInterface, ProposedByAwareInterface, ActionLoggerAwareInterface
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
     * @Groups({"read"})
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $employeeId;

    /**
     * @var EmployeeInterface
     */
    private $employee;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $proposedById;

    /**
     * @var EmployeeInterface
     */
    private $proposedBy;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     *
     * @var \DateTime
     */
    private $overtimeDate;

    /**
     * @Groups({"read"})
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
     * @Groups({"read"})
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
     * @return string
     */
    public function getEmployeeId(): string
    {
        return (string) $this->employeeId;
    }

    /**
     * @param string $employeeId
     */
    public function setEmployeeId(string $employeeId = null)
    {
        $this->employeeId = $employeeId;
    }

    /**
     * @return EmployeeInterface
     */
    public function getEmployee(): ? EmployeeInterface
    {
        return $this->employee;
    }

    /**
     * @param EmployeeInterface $employee
     */
    public function setEmployee(EmployeeInterface $employee = null): void
    {
        $this->employee = $employee;
        if ($this->employee) {
            $this->employeeId = $employee->getId();
        }
    }

    /**
     * @return string
     */
    public function getProposedById(): string
    {
        return (string) $this->proposedById;
    }

    /**
     * @param string $proposedById
     */
    public function setProposedById(string $proposedById = null)
    {
        $this->proposedById = $proposedById;
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
        if ($proposedBy) {
            $this->proposedById = $proposedBy->getId();
        }
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
