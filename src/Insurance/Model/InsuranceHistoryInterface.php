<?php

namespace Persona\Hris\Insurance\Model;

use Persona\Hris\Employee\Model\EmployeeInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface InsuranceHistoryInterface
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
    public function getInsuranceYear(): string;

    /**
     * @return string
     */
    public function getInsuranceMonth(): string;

    /**
     * @return float
     */
    public function getCompanyCost(): float;

    /**
     * @return float
     */
    public function getEmployeeCost(): float;

    /**
     * @return float
     */
    public function getCompanyPercentageFactor(): float;

    /**
     * @return float
     */
    public function getCompanyFixedValueFactor(): float;

    /**
     * @return float
     */
    public function getEmployeePercentageFactor(): float;

    /**
     * @return float
     */
    public function getEmployeeFixedValueFactor(): float;
}
