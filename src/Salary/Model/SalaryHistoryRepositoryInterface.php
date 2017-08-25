<?php

namespace Persona\Hris\Salary\Model;

use Persona\Hris\Repository\RepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface SalaryHistoryRepositoryInterface extends RepositoryInterface
{
    /**
     * @param SalaryHistoryInterface $salaryHistory
     */
    public function inactiveOthers(SalaryHistoryInterface $salaryHistory): void;
}
