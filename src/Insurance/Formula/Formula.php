<?php

namespace Persona\Hris\Insurance\Formula;

use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Insurance\Model\InsuranceInterface;
use Persona\Hris\Salary\Model\BenefitInterface;
use Persona\Hris\Salary\Model\EmployeeBenefitInterface;
use Persona\Hris\Salary\Model\EmployeeBenefitRepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
class Formula implements FormulaInterface
{
    /**
     * @var EmployeeBenefitRepositoryInterface
     */
    private $benefitRepository;

    /**
     * @var CostInterface
     */
    private $employeeCost;

    /**
     * @var CostInterface
     */
    private $companyCost;

    /**
     * @param EmployeeBenefitRepositoryInterface $benefitRepository
     * @param CostInterface                      $employeeCost
     * @param CostInterface                      $companyCost
     */
    public function __construct(EmployeeBenefitRepositoryInterface $benefitRepository, CostInterface $employeeCost, CostInterface $companyCost)
    {
        $this->employeeCost = $employeeCost;
        $this->companyCost = $companyCost;
    }

    /**
     * @param EmployeeInterface  $employee
     * @param InsuranceInterface $insurance
     */
    public function calculate(EmployeeInterface $employee, InsuranceInterface $insurance): void
    {
        $basicSalary = $employee->getBasicSalary();

        $benefit = 0;
        foreach ($this->benefitRepository->findByEmployee($employee) as $employeeBenefit) {
            if (BenefitInterface::TYPE_PLUS === $employeeBenefit->getBenefit()->getBenefitType()) {
                $benefit += $this->getBenefit($employeeBenefit, $basicSalary);
            } else {
                $benefit -= $this->getBenefit($employeeBenefit, $basicSalary);
            }
        }

        /* Need to optimization */
        $this->employeeCost->setCalculatedValue((float) (0 !== $this->employeeCost->getFixedValue()) ? $this->employeeCost->getFixedValue() : ($this->employeeCost * ($basicSalary + $benefit)));
        $this->companyCost->setCalculatedValue((float) (0 !== $this->companyCost->getFixedValue()) ? $this->companyCost->getFixedValue() : ($this->companyCost * ($basicSalary + $benefit)));
    }

    /**
     * @return CostInterface
     */
    public function getEmployeeCost(): CostInterface
    {
        return $this->employeeCost;
    }

    /**
     * @return CostInterface
     */
    public function getCompanyCost(): CostInterface
    {
        return $this->companyCost;
    }

    /**
     * @param EmployeeBenefitInterface $employeeBenefit
     * @param float                    $basicSalary
     *
     * @return float
     */
    private function getBenefit(EmployeeBenefitInterface $employeeBenefit, float $basicSalary): float
    {
        $percentage = $employeeBenefit->getPercentageFromBasicSalary();
        if ($percentage) {
            return round(($percentage / 100) * $basicSalary, 0, PHP_ROUND_HALF_DOWN);
        }

        $percentage = $employeeBenefit->getPercentageFromBenefitValue();
        if ($percentage) {
            return round(($percentage / 100) * $employeeBenefit->getBenefitValue(), 0, PHP_ROUND_HALF_DOWN);
        }

        return $employeeBenefit->getBenefitValue();
    }
}
