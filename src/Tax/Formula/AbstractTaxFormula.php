<?php

namespace Persona\Hris\Tax\Formula;

use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Salary\Model\AdditionalBenefitRepositoryInterface;
use Persona\Hris\Salary\Model\EmployeeBenefitRepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
abstract class AbstractTaxFormula implements TaxFormulaInterface
{
    /**
     * @var EmployeeBenefitRepositoryInterface
     */
    private $employeeBenefitRepository;

    /**
     * @var AdditionalBenefitRepositoryInterface
     */
    private $employeeAdditionalBenefitRepository;

    /**
     * @param EmployeeBenefitRepositoryInterface $employeeBenefitRepository
     * @param AdditionalBenefitRepositoryInterface $additionalBenefitRepository
     */
    public function __construct(EmployeeBenefitRepositoryInterface $employeeBenefitRepository, AdditionalBenefitRepositoryInterface $additionalBenefitRepository)
    {
        $this->employeeBenefitRepository = $employeeBenefitRepository;
        $this->employeeAdditionalBenefitRepository = $additionalBenefitRepository;
    }

    /**
     * @param EmployeeInterface $employee
     *
     * @return float
     */
    protected function getTaxReduction(EmployeeInterface $employee): float
    {
        $taxReductionBenefit = 0;

        $benefits = $this->employeeBenefitRepository->findByEmployee($employee);
        foreach ($benefits as $benefit) {
            if ($benefit->getBenefit()->isTaxReduction()) {
                $taxReductionBenefit += $benefit->getBenefitValue();
            }
        }

        $additionals = $this->employeeAdditionalBenefitRepository->findByEmployee($employee);
        foreach ($additionals as $benefit) {
            if ($benefit->getBenefit()->isTaxReduction()) {
                $taxReductionBenefit += $benefit->getBenefitValue();
            }
        }

        return $taxReductionBenefit;
    }

    /**
     * @param EmployeeInterface $employee
     *
     * @return float
     */
    protected function getTaxableValue(EmployeeInterface $employee): float
    {
        $basicSalary = $employee->getBasicSalary();
        $benefitReduction = $this->getTaxReduction($employee);
        $jobTitleCost = 0.05 * $basicSalary;

        return $basicSalary - $benefitReduction - $jobTitleCost;
    }
}
