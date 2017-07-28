<?php

namespace Persona\Hris\Salary\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface PayrollDetailRepositoryInterface
{
    /**
     * @param PayrollInterface $payroll
     * @param BenefitInterface $benefit
     *
     * @return null|PayrollDetailInterface
     */
    public function findByPayrollAndBenefit(PayrollInterface $payroll, BenefitInterface $benefit): ? PayrollDetailInterface;

    /**
     * @param PayrollInterface $payroll
     *
     * @return PayrollDetailInterface[]
     */
    public function findByPayroll(PayrollInterface $payroll): array;
}
