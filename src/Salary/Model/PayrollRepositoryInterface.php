<?php

namespace Persona\Hris\Salary\Model;

use Persona\Hris\Employee\Model\EmployeeInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface PayrollRepositoryInterface
{
    /**
     * @param EmployeeInterface $employee
     * @param int               $year
     * @param int               $month
     *
     * @return bool
     */
    public function isClosed(EmployeeInterface $employee, int $year, int $month): bool;
}
