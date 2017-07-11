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
     * @return string
     */
    public function getPayrollYear(): string;

    /**
     * @return string
     */
    public function getPayrollMonth(): string;

    /**
     * @return float
     */
    public function getTakeHomePay(): float;

    /**
     * @return bool
     */
    public function isClosed(): bool;

    /**
     * @param bool $closed
     */
    public function setClosed(bool $closed): void;
}
