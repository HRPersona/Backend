<?php

namespace Persona\Hris\Salary\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface MinusBenefitAwareInterface
{
    /**
     * @return string
     */
    public function getMinusBenefitId(): string;

    /**
     * @param string|null $benefit
     */
    public function setMinusBenefitId(string $benefit = null);

    /**
     * @return null|BenefitInterface
     */
    public function getMinusBenefit(): ? BenefitInterface;

    /**
     * @param BenefitInterface|null $benefit
     */
    public function setMinusBenefit(BenefitInterface $benefit = null): void;
}
