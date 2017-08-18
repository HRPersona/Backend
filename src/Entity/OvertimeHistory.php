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
use Persona\Hris\Overtime\Model\EmployeeOvertimeHistoryInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="ov_overtime_histories", indexes={@ORM\Index(name="overtime_history_search_idx", columns={"employee_id"})})
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
class OvertimeHistory implements EmployeeOvertimeHistoryInterface, EmployeeAwareInterface, ActionLoggerAwareInterface
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
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $overtimeYear;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $overtimeMonth;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="float", scale=27, precision=2)
     *
     * @var float
     */
    private $calculatedValue;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="boolean")
     * @Assert\NotBlank()
     *
     * @var bool
     */
    private $closed;

    public function __construct()
    {
        $this->closed = true;
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
     * @return int
     */
    public function getOvertimeYear(): int
    {
        return $this->overtimeYear;
    }

    /**
     * @param int $year
     */
    public function setOvertimeYear(int $year): void
    {
        $this->overtimeYear = $year;
    }

    /**
     * @return int
     */
    public function getOvertimeMonth(): int
    {
        return $this->overtimeMonth;
    }

    /**
     * @param int $month
     */
    public function setOvertimeMonth(int $month): void
    {
        $this->overtimeMonth = $month;
    }

    /**
     * @return float
     */
    public function getCalculatedValue(): float
    {
        return $this->calculatedValue;
    }

    /**
     * @param float $calculatedValue
     */
    public function setCalculatedValue(float $calculatedValue): void
    {
        $this->calculatedValue = $calculatedValue;
    }

    /**
     * @return bool
     */
    public function isClosed(): bool
    {
        return $this->closed;
    }

    /**
     * @param bool $closed
     */
    public function setClosed(bool $closed): void
    {
        $this->closed = $closed;
    }
}
