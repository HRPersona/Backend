<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Attendance\Model\AbsentReasonAwareInterface;
use Persona\Hris\Attendance\Model\AbsentReasonInterface;
use Persona\Hris\Attendance\Model\EmployeeAttendanceInterface;
use Persona\Hris\Attendance\Model\ShiftmentAwareInterface;
use Persona\Hris\Attendance\Model\ShiftmentInterface;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Core\Logger\Model\ActionLoggerAwareInterface;
use Persona\Hris\Core\Upload\UploadableInterface;
use Persona\Hris\Employee\Model\EmployeeAwareInterface;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="at_attendances", indexes={
 *     @ORM\Index(name="attendance_search_idx", columns={"employee_id", "shiftment_id", "absent_reason_id"}),
 *     @ORM\Index(name="attendance_search_idx_employee", columns={"employee_id"}),
 *     @ORM\Index(name="attendance_search_idx_shiftment", columns={"shiftment_id"}),
 *     @ORM\Index(name="attendance_search_idx_absent_reason", columns={"absent_reason_id"})
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
class Attendance implements EmployeeAttendanceInterface, EmployeeAwareInterface, AbsentReasonAwareInterface, ShiftmentAwareInterface, UploadableInterface, ActionLoggerAwareInterface
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
    private $shiftmentId;

    /**
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
     * @Groups({"read"})
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    private $snapShot;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="json", nullable=true)
     *
     * @var string
     */
    private $geoLocation;

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
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $absentReasonId;

    /**
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
        if ($employee) {
            $this->employeeId = $employee->getId();
        }
    }

    /**
     * @return string
     */
    public function getShiftmentId(): string
    {
        return (string) $this->shiftmentId;
    }

    /**
     * @param string $shiftmentId
     */
    public function setShiftmentId(string $shiftmentId = null)
    {
        $this->shiftmentId = $shiftmentId;
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
        if ($shiftment) {
            $this->shiftmentId = $shiftment->getId();
        }
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
    public function getSnapShot(): string
    {
        if ($this->snapShot) {
            return sprintf('%s/%s', $this->getDirectoryPrefix(), $this->snapShot);
        }

        return 'default_avatar.png';
    }

    /**
     * @param string $snapShot
     */
    public function setSnapShot(string $snapShot)
    {
        $this->snapShot = $snapShot;
    }

    /**
     * @return string
     */
    public function getGeoLocation(): string
    {
        return $this->geoLocation;
    }

    /**
     * @param string $geoLocation
     */
    public function setGeoLocation(string $geoLocation)
    {
        $this->geoLocation = $geoLocation;
    }

    /**
     * @return string
     */
    public function getTimeIn(): string
    {
        return (string) $this->timeIn;
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
        return (string) $this->timeOut;
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
        return (string) $this->earlyIn;
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
        return (string) $this->earlyOut;
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
        return (string) $this->lateIn;
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
        return (string) $this->lateOut;
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
     * @return string
     */
    public function getAbsentReasonId(): string
    {
        return (string) $this->absentReasonId;
    }

    /**
     * @param string $absentReasonId
     */
    public function setAbsentReasonId(string $absentReasonId = null)
    {
        $this->absentReasonId = $absentReasonId;
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
        if ($absentReason) {
            $this->absentReasonId = $absentReason->getId();
        }
    }

    /**
     * @return string
     */
    public function getRemark(): ? string
    {
        return (string) $this->remark;
    }

    /**
     * @param string $remark
     */
    public function setRemark(string $remark = null): void
    {
        $this->remark = $remark;
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
            $this->snapShot = $imageExtension; //for triggering changeset
        }
    }

    /**
     * @return string
     */
    public function getTargetField(): string
    {
        return 'snapShot';
    }

    /**
     * @return string
     */
    public function getDirectoryPrefix(): string
    {
        return 'snapshot';
    }
}
