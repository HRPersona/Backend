<?php

namespace Persona\Hris\Overtime\Model;

use Persona\Hris\Employee\Model\EmployeeInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface EmployeeOvertimeCalculationRepositoryInterface
{
    /**
     * @param EmployeeInterface $employee
     * @param int $year
     * @param int $month
     *
     * @return bool
     */
    public function isExisting(EmployeeInterface $employee, int $year, int $month): bool;

    /**
     * @return EmployeeOvertimeCalculationInterface
     */
    public function getExistData(): EmployeeOvertimeCalculationInterface;
}
