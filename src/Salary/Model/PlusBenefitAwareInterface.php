<?php

namespace Persona\Hris\Salary\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface PlusBenefitAwareInterface
{
    /**
     * @return string
     */
    public function getPlusBenefitId(): string;

    /**
     * @param string|null $benefit
     */
    public function setPlusBenefitId(string $benefit = null);

    /**
     * @return null|BenefitInterface
     */
    public function getPlusBenefit(): ? BenefitInterface;

    /**
     * @param BenefitInterface|null $benefit
     */
    public function setPlusBenefit(BenefitInterface $benefit = null): void;
}
