<?php

namespace Persona\Hris\Salary\Model;

use Persona\Hris\Employee\Model\EmployeeInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface AdditionalBenefitRepositoryInterface
{
    /**
     * @param EmployeeInterface $employee
     *
     * @return AdditionalBenefitInterface[]
     */
    public function findByEmployee(EmployeeInterface $employee): array;
}
