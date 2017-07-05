<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Attendance\Model\AbsentReasonInterface;
use Persona\Hris\Attendance\Model\EmployeeAbsentInterface;
use Persona\Hris\Core\Logger\ActionLoggerAwareInterface;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="e_employee_absents")
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
class EmployeeAbsent implements EmployeeAbsentInterface, ActionLoggerAwareInterface
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
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     *
     * @var \DateTime
     */
    private $absentDate;

    /**
     * @Groups({"read", "write"})
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\AbsentReason", fetch="EAGER")
     * @ORM\JoinColumn(name="absent_reason_id", referencedColumnName="id")
     * @Assert\NotBlank()
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
     * @return \DateTime
     */
    public function getAbsentDate(): \DateTime
    {
        return $this->absentDate;
    }

    /**
     * @param \DateTime $absentDate
     */
    public function setAbsentDate(\DateTime $absentDate)
    {
        $this->absentDate = $absentDate;
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
