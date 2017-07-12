<?php

namespace Persona\Hris\Overtime\Formula;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface OvertimeFormulaInterface
{
    /**
     * @param float $overtimeHour
     * @return float
     */
    public function getCalculatedValue(float $overtimeHour): float;
}
