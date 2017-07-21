<?php

namespace Persona\Hris\Tax\Formula;

use Persona\Hris\Employee\Model\EmployeeInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface TaxFormulaInterface
{
    /**
     * @param EmployeeInterface $employee
     *
     * @return float
     */
    public function getCalculatedValue(EmployeeInterface $employee): float;
}
