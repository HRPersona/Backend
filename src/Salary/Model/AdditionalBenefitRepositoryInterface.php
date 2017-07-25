<?php

namespace Persona\Hris\Salary\Model;

use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Repository\RepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface AdditionalBenefitRepositoryInterface extends RepositoryInterface
{
    /**
     * @param EmployeeInterface $employee
     *
     * @return AdditionalBenefitInterface[]
     */
    public function findByEmployee(EmployeeInterface $employee): array;
}
