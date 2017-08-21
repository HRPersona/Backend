<?php

namespace Persona\Hris\Salary\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface PayrollDetailInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return null|PayrollInterface
     */
    public function getPayroll(): ? PayrollInterface;

    /**
     * @param PayrollInterface $payroll
     */
    public function setPayroll(PayrollInterface $payroll): void;

    /**
     * @return null|BenefitInterface
     */
    public function getBenefit(): ? BenefitInterface;

    /**
     * @param BenefitInterface $benefit
     */
    public function setBenefit(BenefitInterface $benefit): void;

    /**
     * @return string
     */
    public function getBenefitType(): string;

    /**
     * @param string $type
     */
    public function setBenefitType(string $type): void;

    /**
     * @return float
     */
    public function getBenefitValue(): float;

    /**
     * @param float $value
     */
    public function setBenefitValue(float $value): void;
}
