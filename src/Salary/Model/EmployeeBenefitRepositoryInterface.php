<?php

namespace Persona\Hris\Salary\Model;

use Persona\Hris\Employee\Model\EmployeeInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface EmployeeBenefitRepositoryInterface
{
    /**
     * @param EmployeeInterface $employee
     *
     * @return EmployeeBenefitInterface[]
     */
    public function findByEmployee(EmployeeInterface $employee): array;
}
