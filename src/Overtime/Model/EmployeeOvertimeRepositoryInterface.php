<?php

namespace Persona\Hris\Overtime\Model;

use Persona\Hris\Employee\Model\EmployeeInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface EmployeeOvertimeRepositoryInterface
{
    /**
     * @param \DateTime $date
     * @param EmployeeInterface $employee
     *
     * @return EmployeeOvertimeInterface[]
     */
    public function findByEmployee(\DateTime $date, EmployeeInterface $employee): array;
}
