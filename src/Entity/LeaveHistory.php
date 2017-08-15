<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Core\Logger\Model\ActionLoggerAwareInterface;
use Persona\Hris\Employee\Model\ApprovedByAwareInterface;
use Persona\Hris\Employee\Model\EmployeeAwareInterface;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Leave\Model\EmployeeLeaveInterface;
use Persona\Hris\Leave\Model\LeaveAwareInterface;
use Persona\Hris\Leave\Model\LeaveInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="lv_leave_histories", indexes={
 *     @ORM\Index(name="leave_history_search_idx", columns={"employee_id", "leave_id", "approved_by_id"}),
 *     @ORM\Index(name="leave_history_search_employee_id", columns={"employee_id"}),
 *     @ORM\Index(name="leave_history_search_leave", columns={"leave_id"}),
 *     @ORM\Index(name="leave_history_search_approved_by", columns={"approved_by_id"})
 * })
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
class LeaveHistory implements EmployeeLeaveInterface, EmployeeAwareInterface, LeaveAwareInterface, ApprovedByAwareInterface, ActionLoggerAwareInterface
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
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $leaveId;

    /**
     * @var LeaveInterface
     */
    private $leave;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     *
     * @var \DateTime
     */
    private $leaveDate;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     *
     * @var int
     */
    private $leaveDay;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $remark;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    private $approved;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    private $approvedById;

    /**
     * @var EmployeeInterface
     */
    private $approvedBy;

    public function __construct()
    {
        $this->approved = false;
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
    public function getLeaveId(): string
    {
        return (string) $this->leaveId;
    }

    /**
     * @param string $leaveId
     */
    public function setLeaveId(string $leaveId = null)
    {
        $this->leaveId = $leaveId;
    }

    /**
     * @return LeaveInterface
     */
    public function getLeave(): ? LeaveInterface
    {
        return $this->leave;
    }

    /**
     * @param LeaveInterface $leave
     */
    public function setLeave(LeaveInterface $leave = null): void
    {
        $this->leave = $leave;
        if ($leave) {
            $this->leaveId = $leave->getId();
        }
    }

    /**
     * @return \DateTime
     */
    public function getLeaveDate(): \DateTime
    {
        return $this->leaveDate;
    }

    /**
     * @param \DateTime $leaveDate
     */
    public function setLeaveDate(\DateTime $leaveDate)
    {
        $this->leaveDate = $leaveDate;
    }

    /**
     * @return int
     */
    public function getLeaveDay(): int
    {
        return $this->leaveDay;
    }

    /**
     * @param int $leaveDay
     */
    public function setLeaveDay(int $leaveDay)
    {
        $this->leaveDay = $leaveDay;
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

    /**
     * @return bool
     */
    public function isApproved(): bool
    {
        return $this->approved;
    }

    /**
     * @param bool $approved
     */
    public function setApproved(bool $approved): void
    {
        $this->approved = $approved;
    }

    /**
     * @return string
     */
    public function getApprovedById(): string
    {
        return (string) $this->approvedById;
    }

    /**
     * @param string $approvedById
     */
    public function setApprovedById(string $approvedById = null)
    {
        $this->approvedById = $approvedById;
    }

    /**
     * @return EmployeeInterface
     */
    public function getApprovedBy(): ? EmployeeInterface
    {
        return $this->approvedBy;
    }

    /**
     * @param EmployeeInterface $approvedBy
     */
    public function setApprovedBy(EmployeeInterface $approvedBy = null): void
    {
        $this->approvedBy = $approvedBy;
        if ($approvedBy) {
            $this->approvedById = $approvedBy->getId();
        }
    }
}
