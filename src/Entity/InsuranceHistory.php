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
use Persona\Hris\Insurance\Model\InsuranceHistoryInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity()
 * @ORM\Table(name="in_insurance_histories", indexes={@ORM\Index(name="insurance_history_search_idx", columns={"employee_id"})})
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
class InsuranceHistory implements InsuranceHistoryInterface, EmployeeAwareInterface, ActionLoggerAwareInterface
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
    private $insuranceYear;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $insuranceMonth;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="float", scale=27, precision=2)
     *
     * @var float
     */
    private $companyCost;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="float", scale=27, precision=2)
     *
     * @var float
     */
    private $employeeCost;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="float", scale=5, precision=2)
     *
     * @var float
     */
    private $companyPercentageFactor;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="float", scale=27, precision=2)
     *
     * @var float
     */
    private $companyFixedValueFactor;
    /**
     * @Groups({"read"})
     * @ORM\Column(type="float", scale=5, precision=2)
     *
     * @var float
     */
    private $employeePercentageFactor;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="float", scale=27, precision=2)
     *
     * @var float
     */
    private $employeeFixedValueFactor;

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
    public function getInsuranceYear(): int
    {
        return $this->insuranceYear;
    }

    /**
     * @param int $insuranceYear
     */
    public function setInsuranceYear(int $insuranceYear)
    {
        $this->insuranceYear = $insuranceYear;
    }

    /**
     * @return int
     */
    public function getInsuranceMonth(): int
    {
        return $this->insuranceMonth;
    }

    /**
     * @param int $insuranceMonth
     */
    public function setInsuranceMonth(int $insuranceMonth)
    {
        $this->insuranceMonth = $insuranceMonth;
    }

    /**
     * @return float
     */
    public function getCompanyCost(): float
    {
        return $this->companyCost;
    }

    /**
     * @param float $companyCost
     */
    public function setCompanyCost(float $companyCost)
    {
        $this->companyCost = $companyCost;
    }

    /**
     * @return float
     */
    public function getEmployeeCost(): float
    {
        return $this->employeeCost;
    }

    /**
     * @param float $employeeCost
     */
    public function setEmployeeCost(float $employeeCost)
    {
        $this->employeeCost = $employeeCost;
    }

    /**
     * @return float
     */
    public function getCompanyPercentageFactor(): float
    {
        return $this->companyPercentageFactor;
    }

    /**
     * @param float $companyPercentageFactor
     */
    public function setCompanyPercentageFactor(float $companyPercentageFactor)
    {
        $this->companyPercentageFactor = $companyPercentageFactor;
    }

    /**
     * @return float
     */
    public function getCompanyFixedValueFactor(): float
    {
        return $this->companyFixedValueFactor;
    }

    /**
     * @param float $companyFixedValueFactor
     */
    public function setCompanyFixedValueFactor(float $companyFixedValueFactor)
    {
        $this->companyFixedValueFactor = $companyFixedValueFactor;
    }

    /**
     * @return float
     */
    public function getEmployeePercentageFactor(): float
    {
        return $this->employeePercentageFactor;
    }

    /**
     * @param float $employeePercentageFactor
     */
    public function setEmployeePercentageFactor(float $employeePercentageFactor)
    {
        $this->employeePercentageFactor = $employeePercentageFactor;
    }

    /**
     * @return float
     */
    public function getEmployeeFixedValueFactor(): float
    {
        return $this->employeeFixedValueFactor;
    }

    /**
     * @param float $employeeFixedValueFactor
     */
    public function setEmployeeFixedValueFactor(float $employeeFixedValueFactor)
    {
        $this->employeeFixedValueFactor = $employeeFixedValueFactor;
    }
}
