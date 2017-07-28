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
class BpjsJhtFormula implements FormulaInterface
{
    /**
     * @var EmployeeBenefitRepositoryInterface
     */
    private $employeeBenefitRepository;

    /**
     * @param EmployeeBenefitRepositoryInterface $employeeBenefitRepository
     */
    public function __construct(EmployeeBenefitRepositoryInterface $employeeBenefitRepository)
    {
        $this->employeeBenefitRepository = $employeeBenefitRepository;
    }

    /**
     * @param EmployeeInterface $employee
     * @param InsuranceInterface $insurance
     *
     * @return float
     */
    public function calculate(EmployeeInterface $employee, InsuranceInterface $insurance): float
    {
        $basicSalary = $employee->getBasicSalary();

        foreach ($this->employeeBenefitRepository->findByEmployee($employee) as $employeeBenefit) {
            if (BenefitInterface::TYPE_PLUS === $employeeBenefit->getBenefit()->getBenefitType()) {
                $basicSalary += $this->getBenefit($employeeBenefit, $basicSalary);
            } else {
                $basicSalary -= $this->getBenefit($employeeBenefit, $basicSalary);
            }
        }
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
