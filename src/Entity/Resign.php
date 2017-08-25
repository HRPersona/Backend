<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Allocation\Model\EmployeeResignInterface;
use Persona\Hris\Allocation\Model\ResignReasonAwareInterface;
use Persona\Hris\Allocation\Model\ResignReasonInterface;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Core\Logger\Model\ActionLoggerAwareInterface;
use Persona\Hris\Employee\Model\EmployeeAwareInterface;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="ja_resigns", indexes={
 *     @ORM\Index(name="resign_search_idx", columns={"employee_id", "resign_reason_id"}),
 *     @ORM\Index(name="resign_search_idx_employee", columns={"employee_id"}),
 *     @ORM\Index(name="resign_search_idx_resign_reason", columns={"resign_reason_id"})
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
class Resign implements EmployeeResignInterface, EmployeeAwareInterface, ResignReasonAwareInterface, ActionLoggerAwareInterface
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
    private $resignDate;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $resignReasonId;

    /**
     * @var ResignReasonInterface
     */
    private $resignReason;

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
     * @return \DateTime
     */
    public function getResignDate(): \DateTime
    {
        return $this->resignDate;
    }

    /**
     * @param \DateTime $resignDate
     */
    public function setResignDate(\DateTime $resignDate): void
    {
        $this->resignDate = $resignDate;
    }

    /**
     * @return string
     */
    public function getResignReasonId(): string
    {
        return (string) $this->resignReasonId;
    }

    /**
     * @param string $resignReasonId
     */
    public function setResignReasonId(string $resignReasonId = null)
    {
        $this->resignReasonId = $resignReasonId;
    }

    /**
     * @return ResignReasonInterface
     */
    public function getResignReason(): ? ResignReasonInterface
    {
        return $this->resignReason;
    }

    /**
     * @param ResignReasonInterface $resignReason
     */
    public function setResignReason(ResignReasonInterface $resignReason = null): void
    {
        $this->resignReason = $resignReason;
        if ($resignReason) {
            $this->resignReasonId = $resignReason->getId();
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
