<?php

namespace Persona\Hris\Overtime\Formula;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
class HolidayFormula implements OvertimeFormulaInterface
{
    /**
     * @param float $overtimeHour
     *
     * @return float
     */
    public function getCalculatedValue(float $overtimeHour): float
    {
        if (8 < $overtimeHour) {
            //Delepan jam pertama dikali 2
            $calculatedValue = 2 * 8;
            $overtimeHour = $overtimeHour - 8;

            //Selebihnya dikalikan 3
            return $calculatedValue + (3 * $overtimeHour);
        }

        //Delepan jam pertama dikali 2
        return 2 * $overtimeHour;
    }
}
