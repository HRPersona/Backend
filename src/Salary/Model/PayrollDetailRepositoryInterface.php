<?php

namespace Persona\Hris\Salary\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface PayrollDetailRepositoryInterface
{
    /**
     * @param PayrollInterface $payroll
     *
     * @return null|PayrollDetailInterface
     */
    public function findByPayroll(PayrollInterface $payroll): ? PayrollDetailInterface;
}
