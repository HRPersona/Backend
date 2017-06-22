<?php

namespace Persona\Hris\Salary\Model;

use Persona\Hris\Employee\Model\EmployeeInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface AdditionalBenefitInterface
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
    public function setEmployee(EmployeeInterface $employee): void;

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
