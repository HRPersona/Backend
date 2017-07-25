<?php

namespace Persona\Hris\Tax\Model;

use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Repository\RepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface TaxHistoryRepositoryInterface extends RepositoryInterface
{
    /**
     * @param EmployeeInterface $employee
     * @param int               $year
     * @param int               $month
     *
     * @return null|TaxHistoryInterface
     */
    public function findByEmployeeAndPeriod(EmployeeInterface $employee, int $year, int $month): ? TaxHistoryInterface;
}
