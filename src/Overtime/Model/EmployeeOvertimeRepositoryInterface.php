<?php

namespace Persona\Hris\Overtime\Model;

use Persona\Hris\Employee\Model\EmployeeInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface EmployeeOvertimeRepositoryInterface
{
    /**
     * @param EmployeeInterface $employee
     *
     * @return EmployeeOvertimeInterface[]
     */
    public function findByEmployee(EmployeeInterface $employee): array;
}