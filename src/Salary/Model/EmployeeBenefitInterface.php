<?php

namespace Persona\Hris\Salary\Model;

use Persona\Hris\Employee\Model\EmployeeInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface EmployeeBenefitInterface
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
     * @return null|BenefitInterface
     */
    public function getBenefit(): ? BenefitInterface;

    /**
     * @param BenefitInterface $benefit
     */
    public function setBenefit(BenefitInterface $benefit = null): void;

    /**
     * @return float|null
     */
    public function getPercentageFromBasicSalary(): ? float;

    /**
     * @return float|null
     */
    public function getPercentageFromBenefitValue(): ? float;

    /**
     * @return float
     */
    public function getBenefitValue():? float;

    /**
     * @return bool
     */
    public function isUsePercentage(): bool;
}
