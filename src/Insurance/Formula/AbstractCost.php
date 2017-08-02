<?php

namespace Persona\Hris\Insurance\Formula;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
abstract class AbstractCost implements CostInterface
{
    /**
     * @var float
     */
    private $calculatedValue;

    /**
     * @return float
     */
    public function getCalculatedValue(): float
    {
        return (float) $this->calculatedValue;
    }

    /**
     * @param float $calculatedValue
     */
    public function setCalculatedValue(float $calculatedValue): void
    {
        $this->calculatedValue = $calculatedValue;
    }
}
