<?php

namespace Persona\Hris\Salary\Model;

use Persona\Hris\Repository\RepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface PayrollPeriodRepositoryInterface extends RepositoryInterface
{
    /**
     * @param PayrollPeriodInterface $payrollPeriod
     */
    public function inactiveOthers(PayrollPeriodInterface $payrollPeriod): void;
}
