<?php

namespace Persona\Hris\Tax\Formula;

use Persona\Hris\Salary\Model\PayrollInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface TaxFormulaInterface
{
    /**
     * @param PayrollInterface $payroll
     *
     * @return float
     */
    public function getCalculatedValue(PayrollInterface $payroll): float;
}
