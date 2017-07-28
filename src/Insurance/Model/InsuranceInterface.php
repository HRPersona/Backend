<?php

namespace Persona\Hris\Insurance\Model;

use Persona\Hris\Salary\Model\BenefitInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface InsuranceInterface
{
    public function getId(): string;

    public function getName(): string;

    public function getPlusBenefit(): ? BenefitInterface;

    public function setPlusBenefit(BenefitInterface $benefit = null): void;

    public function getMinusBenefit(): ? BenefitInterface;

    public function setMinusBenefit(BenefitInterface $benefit = null): void;

    public function getFormulaId(): string;
}
