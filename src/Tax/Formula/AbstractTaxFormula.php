<?php

namespace Persona\Hris\Tax\Formula;

use Persona\Hris\Employee\Model\EmployeeInterface;
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
     * @param EmployeeBenefitRepositoryInterface $employeeBenefitRepository
     */
    public function __construct(EmployeeBenefitRepositoryInterface $employeeBenefitRepository)
    {
        $this->employeeBenefitRepository = $employeeBenefitRepository;
    }

    /**
     * @param EmployeeInterface $employee
     *
     * @return float
     */
    public function getTaxReduction(EmployeeInterface $employee): float
    {
        $taxReductionBenefit = 0;
        $benefits = $this->employeeBenefitRepository->findByEmployee($employee);
        foreach ($benefits as $benefit) {
            if ($benefit->getBenefit()->isTaxReduction()) {
                $taxReductionBenefit += $benefit->getBenefitValue();
            }
        }

        return $taxReductionBenefit;
    }
}
