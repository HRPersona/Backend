<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Attendance\Model\AbsentReasonInterface;
use Persona\Hris\Attendance\Model\EmployeeAttendanceInterface;
use Persona\Hris\Attendance\Model\ShiftmentInterface;
use Persona\Hris\Core\Logger\ActionLoggerAwareInterface;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="e_employee_attendances")
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
class EmployeeAttendance implements EmployeeAttendanceInterface, ActionLoggerAwareInterface
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
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\Shiftment", fetch="EAGER")
     * @ORM\JoinColumn(name="shiftment_id", referencedColumnName="id")
     * @Assert\NotBlank()
     *
     * @var ShiftmentInterface
     */
    private $shiftment;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     *
     * @var \DateTime
     */
    private $attendanceDate;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $timeIn;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $timeOut;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $earlyIn;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $earlyOut;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $lateIn;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $lateOut;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    private $absent;

    /**
     * @Groups({"read", "write"})
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\AbsentReason", fetch="EAGER")
     * @ORM\JoinColumn(name="absen_reason_id", referencedColumnName="id")
     *
     * @var AbsentReasonInterface
     */
    private $absentReason;

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
        $this->absent = false;
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
    }

    /**
     * @return ShiftmentInterface
     */
    public function getShiftment(): ? ShiftmentInterface
    {
        return $this->shiftment;
    }

    /**
     * @param ShiftmentInterface $shiftment
     */
    public function setShiftment(ShiftmentInterface $shiftment = null): void
    {
        $this->shiftment = $shiftment;
    }

    /**
     * @return \DateTime
     */
    public function getAttendanceDate(): \DateTime
    {
        return $this->attendanceDate;
    }

    /**
     * @param \DateTime $attendanceDate
     */
    public function setAttendanceDate(\DateTime $attendanceDate): void
    {
        $this->attendanceDate = $attendanceDate;
    }

    /**
     * @return string
     */
    public function getTimeIn(): string
    {
        return $this->timeIn;
    }

    /**
     * @param string $timeIn
     */
    public function setTimeIn(string $timeIn)
    {
        $this->timeIn = $timeIn;
    }

    /**
     * @return string
     */
    public function getTimeOut(): string
    {
        return $this->timeOut;
    }

    /**
     * @param string $timeOut
     */
    public function setTimeOut(string $timeOut)
    {
        $this->timeOut = $timeOut;
    }

    /**
     * @return string
     */
    public function getEarlyIn(): string
    {
        return $this->earlyIn;
    }

    /**
     * @param string $earlyIn
     */
    public function setEarlyIn(string $earlyIn): void
    {
        $this->earlyIn = $earlyIn;
    }

    /**
     * @return string
     */
    public function getEarlyOut(): string
    {
        return $this->earlyOut;
    }

    /**
     * @param string $earlyOut
     */
    public function setEarlyOut(string $earlyOut): void
    {
        $this->earlyOut = $earlyOut;
    }

    /**
     * @return string
     */
    public function getLateIn(): string
    {
        return $this->lateIn;
    }

    /**
     * @param string $lateIn
     */
    public function setLateIn(string $lateIn): void
    {
        $this->lateIn = $lateIn;
    }

    /**
     * @return string
     */
    public function getLateOut(): string
    {
        return $this->lateOut;
    }

    /**
     * @param string $lateOut
     */
    public function setLateOut(string $lateOut): void
    {
        $this->lateOut = $lateOut;
    }

    /**
     * @return bool
     */
    public function isAbsent(): bool
    {
        return $this->absent;
    }

    /**
     * @param bool $absent
     */
    public function setAbsent(bool $absent = null): void
    {
        $this->absent = $absent;
    }

    /**
     * @return AbsentReasonInterface
     */
    public function getAbsentReason(): ? AbsentReasonInterface
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
    public function getRemark(): ? string
    {
        return $this->remark;
    }

    /**
     * @param string $remark
     */
    public function setRemark(string $remark = null): void
    {
        $this->remark = $remark;
    }
}
