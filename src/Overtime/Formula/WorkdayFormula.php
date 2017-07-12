<?php

namespace Persona\Hris\Overtime\Formula;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
class WorkdayFormula implements OvertimeFormulaInterface
{
    /**
     * @param float $overtimeHour
     * @return float
     */
    public function getCalculatedValue(float $overtimeHour): float
    {
        if (1 < $overtimeHour) {
            //Satu jam pertama kali 1.5
            $calculatedValue = 1.5 * 1;
            $overtimeHour = $overtimeHour - 1;

            if (2 < $overtimeHour) {
                //Dua jam kedua kali 2
                $calculatedValue = $calculatedValue + (2 * 2);
                $overtimeHour = $overtimeHour -2;

                //Selebihnya kali 3
                return $calculatedValue + (3 * $overtimeHour);
            }

            //Dua jam kedua kali 2
            return $calculatedValue + (2 * $overtimeHour);
        }

        //Satu jam pertama kali 1.5
        return 1.5 * $overtimeHour;
    }
}
