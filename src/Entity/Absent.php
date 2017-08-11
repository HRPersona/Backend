<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Attendance\Model\AbsentReasonAwareInterface;
use Persona\Hris\Attendance\Model\AbsentReasonInterface;
use Persona\Hris\Attendance\Model\EmployeeAbsentInterface;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Core\Logger\Model\ActionLoggerAwareInterface;
use Persona\Hris\Employee\Model\EmployeeAwareInterface;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="at_absents", indexes={
 *     @ORM\Index(name="absent_search_idx", columns={"employee_id", "absent_reason_id"}),
 *     @ORM\Index(name="absent_search_idx_employee", columns={"employee_id"}),
 *     @ORM\Index(name="absent_search_idx_absent_reason", columns={"absent_reason_id"})
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
class Absent implements EmployeeAbsentInterface, EmployeeAwareInterface, AbsentReasonAwareInterface, ActionLoggerAwareInterface
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
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     *
     * @var \DateTime
     */
    private $absentDate;

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
        if ($employee) {
            $this->employeeId = $employee->getId();
        }
    }

    /**
     * @return \DateTime
     */
    public function getAbsentDate(): \DateTime
    {
        return $this->absentDate;
    }

    /**
     * @param \DateTime $absentDate
     */
    public function setAbsentDate(\DateTime $absentDate): void
    {
        $this->absentDate = $absentDate;
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
