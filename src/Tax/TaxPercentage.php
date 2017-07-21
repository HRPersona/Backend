<?php

namespace Persona\Hris\Tax;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class TaxPercentage
{
    /**
     * @param float $grossYearlySalary
     * @param bool  $haveTaxIdentity
     *
     * @return float
     */
    public static function getPercentageValue(float $grossYearlySalary, $haveTaxIdentity = true): float
    {
        if (50000000 > $grossYearlySalary) {
            return $haveTaxIdentity ? 0.25 : 0.05;
        }

        if (50000000 < $grossYearlySalary && 250000000 > $grossYearlySalary) {
            return $haveTaxIdentity ? 0.35 : 0.15;
        }

        if (250000000 < $grossYearlySalary && 500000000 > $grossYearlySalary) {
            return  $haveTaxIdentity ? 0.45 : 0.25;
        }

        return $haveTaxIdentity ? 0.50 : 0.30;
    }
}
