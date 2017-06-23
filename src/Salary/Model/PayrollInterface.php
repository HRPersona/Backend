<?php

namespace Persona\Hris\Salary\Model;

use Persona\Hris\Employee\Model\EmployeeInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface PayrollInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return null|EmployeeInterface
     */
    public function getEmployee(): ? EmployeeInterface;

    /**
     * @param EmployeeInterface $employee
     */
    public function setEmployee(EmployeeInterface $employee = null): void;

    /**
     * @return int
     */
    public function getPayrollYear(): int;

    /**
     * @return int
     */
    public function getPayrollMonth(): int;

    /**
     * @return null|BenefitInterface
     */
    public function getBenefit(): ? BenefitInterface;

    /**
     * @param BenefitInterface $benefit
     */
    public function setBenefit(BenefitInterface $benefit): void;

    /**
     * @return float
     */
    public function getBenefitValue(): float;
}
