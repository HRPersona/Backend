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
use Persona\Hris\Salary\Model\PayrollInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="sa_payrolls", indexes={@ORM\Index(name="payroll_search_idx", columns={"employee_id"})})
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
class Payroll implements PayrollInterface, EmployeeAwareInterface, ActionLoggerAwareInterface
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
     * @ORM\Column(type="integer", length=4)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $payrollYear;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="integer", length=2)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $payrollMonth;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="float", scale=27, precision=2)
     * @Assert\NotBlank()
     *
     * @var float
     */
    private $basicSalary;

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
     * @ORM\Column(type="float", scale=27, precision=2)
     * @Assert\NotBlank()
     *
     * @var float
     */
    private $takeHomePay;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    private $closed;

    public function __construct()
    {
        $this->overtimeValue = (float) 0;
        $this->closed = false;
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
    public function getPayrollYear(): string
    {
        return $this->payrollYear;
    }

    /**
     * @param string $payrollYear
     */
    public function setPayrollYear(string $payrollYear)
    {
        $this->payrollYear = $payrollYear;
    }

    /**
     * @return string
     */
    public function getPayrollMonth(): string
    {
        return $this->payrollMonth;
    }

    /**
     * @param string $payrollMonth
     */
    public function setPayrollMonth(string $payrollMonth)
    {
        $this->payrollMonth = $payrollMonth;
    }

    /**
     * @return float
     */
    public function getBasicSalary(): float
    {
        return $this->basicSalary;
    }

    /**
     * @param float $basicSalary
     */
    public function setBasicSalary(float $basicSalary)
    {
        $this->basicSalary = $basicSalary;
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
     * @return float
     */
    public function getTakeHomePay(): float
    {
        return $this->takeHomePay;
    }

    /**
     * @param float $takeHomePay
     */
    public function setTakeHomePay(float $takeHomePay)
    {
        $this->takeHomePay = $takeHomePay;
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
