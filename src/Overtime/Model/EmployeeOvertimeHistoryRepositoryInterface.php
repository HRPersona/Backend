<?php

namespace Persona\Hris\Overtime\Model;

use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Repository\RepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface EmployeeOvertimeHistoryRepositoryInterface extends RepositoryInterface
{
    /**
     * @param EmployeeInterface $employee
     * @param int               $year
     * @param int               $month
     *
     * @return bool
     */
    public function isExisting(EmployeeInterface $employee, int $year, int $month): bool;

    /**
     * @param EmployeeInterface $employee
     * @param int               $year
     * @param int               $month
     *
     * @return float
     */
    public function getCalculationByEmployee(EmployeeInterface $employee, int $year, int $month): float;

    /**
     * @return EmployeeOvertimeHistoryInterface
     */
    public function getExistData(): EmployeeOvertimeHistoryInterface;
}
