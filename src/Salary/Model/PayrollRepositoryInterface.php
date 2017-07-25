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

    /**
     * @param int $year
     * @param int $month
     */
    public function closingPeriod(int $year, int $month): void;

    /**
     * @param string $id
     *
     * @return null|PayrollInterface
     */
    public function find(string $id): ? PayrollInterface;
}
