<?php

namespace Persona\Hris\Salary\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface PayrollPeriodRepositoryInterface
{
    /**
     * @param PayrollPeriodInterface $payrollPeriod
     */
    public function inactiveOthers(PayrollPeriodInterface $payrollPeriod): void;
}
