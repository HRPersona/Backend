<?php

namespace Persona\Hris\Insurance\Model;

use Persona\Hris\Salary\Model\BenefitInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface InsuranceInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return null|BenefitInterface
     */
    public function getPlusBenefit(): ? BenefitInterface;

    /**
     * @param BenefitInterface|null $benefit
     */
    public function setPlusBenefit(BenefitInterface $benefit = null): void;

    /**
     * @return null|BenefitInterface
     */
    public function getMinusBenefit(): ? BenefitInterface;

    /**
     * @param BenefitInterface|null $benefit
     */
    public function setMinusBenefit(BenefitInterface $benefit = null): void;

    /**
     * @return string
     */
    public function getFormulaId(): string;
}
