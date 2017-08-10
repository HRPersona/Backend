<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Core\Logger\Model\ActionLoggerAwareInterface;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Salary\Model\PayrollInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="sa_payrolls")
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
class Payroll implements PayrollInterface, ActionLoggerAwareInterface
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
     * @ORM\Column(type="integer", length=4)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $payrollYear;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="integer", length=2)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $payrollMonth;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="float", scale=27, precision=2)
     * @Assert\NotBlank()
     *
     * @var float
     */
    private $basicSalary;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="float", scale=27, precision=2)
     * @Assert\NotBlank()
     *
     * @var float
     */
    private $overtimeValue;

    /**
     * @Groups({"read", "write"})
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
