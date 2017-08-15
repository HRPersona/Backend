<?php

namespace Persona\Hris\Salary\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface PayrollAwareInterface
{
    /**
     * @return string
     */
    public function getPayrollId(): string;

    /**
     * @param string|null $payroll
     */
    public function setPayrollId(string $payroll = null);

    /**
     * @return null|PayrollInterface
     */
    public function getPayroll(): ? PayrollInterface;

    /**
     * @param PayrollInterface|null $payroll
     */
    public function setPayroll(PayrollInterface $payroll = null): void;
}
