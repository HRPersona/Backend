<?php

namespace Persona\Hris\Insurance\Formula;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface CostInterface
{
    /**
     * @return float|null
     */
    public function getPercentageValue(): ? float;

    /**
     * @return float|null
     */
    public function getFixedValue(): ? float;

    /**
     * @return float
     */
    public function getCalculatedValue(): float;

    /**
     * @param float $calculatedValue
     */
    public function setCalculatedValue(float $calculatedValue): void;
}
