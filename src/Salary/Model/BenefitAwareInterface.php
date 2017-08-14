<?php

namespace Persona\Hris\Salary\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface BenefitAwareInterface
{
    /**
     * @return string
     */
    public function getBenefitId(): string;

    /**
     * @param string|null $benefit
     */
    public function setBenefitId(string $benefit = null);

    /**
     * @return null|BenefitInterface
     */
    public function getBenefit(): ? BenefitInterface;

    /**
     * @param BenefitInterface|null $benefit
     */
    public function setBenefit(BenefitInterface $benefit = null): void;
}
