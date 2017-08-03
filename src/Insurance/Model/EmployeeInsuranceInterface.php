<?php

namespace Persona\Hris\Insurance\Model;

use Persona\Hris\Employee\Model\EmployeeInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface EmployeeInsuranceInterface
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
     * @return null|InsuranceInterface
     */
    public function getInsurance(): ? InsuranceInterface;

    /**
     * @param InsuranceInterface $insurance
     */
    public function setInsurance(InsuranceInterface $insurance = null): void;
}
