<?php

namespace Persona\Hris\Tax\Model;

use Persona\Hris\Employee\Model\EmployeeInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface TaxHistoryInterface
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
    public function getTaxYear(): string;

    /**
     * @return string
     */
    public function getTaxMonth(): string;

    /**
     * @return float
     */
    public function getTaxValue(): float;
}
