<?php

namespace Persona\Hris\Insurance\Formula;

use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Insurance\Model\InsuranceInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface FormulaInterface
{
    /**
     * @param EmployeeInterface  $employee
     * @param InsuranceInterface $insurance
     */
    public function calculate(EmployeeInterface $employee, InsuranceInterface $insurance): void;

    /**
     * @return CostInterface
     */
    public function getEmployeeCost(): CostInterface;

    /**
     * @return CostInterface
     */
    public function getCompanyCost(): CostInterface;
}
