<?php

namespace Persona\Hris\Insurance\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface InsuranceAwareInterface
{
    /**
     * @return string
     */
    public function getInsuranceId(): string;

    /**
     * @param string|null $insurance
     */
    public function setInsuranceId(string $insurance = null);

    /**
     * @return null|InsuranceInterface
     */
    public function getInsurance(): ? InsuranceInterface;

    /**
     * @param InsuranceInterface|null $insurance
     */
    public function setInsurance(InsuranceInterface $insurance = null): void;
}
