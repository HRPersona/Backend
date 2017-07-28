<?php

namespace Persona\Hris\Tax\Formula;

use Persona\Hris\Salary\Model\BenefitInterface;
use Persona\Hris\Salary\Model\PayrollDetailRepositoryInterface;
use Persona\Hris\Salary\Model\PayrollInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
abstract class AbstractTaxFormula implements TaxFormulaInterface
{
    /**
     * @var PayrollDetailRepositoryInterface
     */
    private $payrollDetailRepository;

    /**
     * @param PayrollDetailRepositoryInterface $payrollDetailRepository
     */
    public function __construct(PayrollDetailRepositoryInterface $payrollDetailRepository)
    {
        $this->payrollDetailRepository = $payrollDetailRepository;
    }

    /**
     * @param PayrollInterface $payroll
     *
     * @return float
     */
    protected function getTaxReduction(PayrollInterface $payroll): float
    {
        $taxReductionBenefit = 0;

        foreach ($this->payrollDetailRepository->findByPayroll($payroll) as $payrollDetail) {
            $benefit = $payrollDetail->getBenefit();
            if ($benefit && $benefit->isTaxReduction() && BenefitInterface::TYPE_PLUS === $benefit->getBenefitType()) {
                $taxReductionBenefit += $payrollDetail->getBenefitValue();
            }
        }

        return $taxReductionBenefit;
    }

    /**
     * @param PayrollInterface $payroll
     *
     * @return float
     */
    protected function getTaxableValue(PayrollInterface $payroll): float
    {
        $basicSalary = $payroll->getEmployee()->getBasicSalary();
        $benefitReduction = $this->getTaxReduction($payroll);
        $jobTitleCost = 0.05 * $basicSalary;

        return $basicSalary - $benefitReduction - $jobTitleCost;
    }
}
