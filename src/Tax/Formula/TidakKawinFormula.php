<?php

namespace Persona\Hris\Tax\Formula;

use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Tax\TaxPercentage;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
class TidakKawinFormula extends AbstractTaxFormula
{
    const TK0 = 54000000;
    const TK1 = 58500000;
    const TK2 = 63000000;
    const TK3 = 67500000;

    /**
     * @param EmployeeInterface $employee
     *
     * @return float
     */
    public function getCalculatedValue(EmployeeInterface $employee): float
    {
        $taxable = 12 * $this->getTaxableValue($employee); //Penghasilan netto setahun
        $taxPercentage = TaxPercentage::getPercentageValue($taxable); //Persentase pajak berdasarkan netto

        $taxReduce = self::TK0; //PTKP
        switch ($employee->getTaxGroup()) {
            case EmployeeInterface::TAX_TK_1:
                $taxReduce = self::TK1;
                break;
            case EmployeeInterface::TAX_TK_2:
                $taxReduce = self::TK2;
                break;
            case EmployeeInterface::TAX_TK_3:
                $taxReduce = self::TK3;
                break;
        }

        $taxable = $taxable - $taxReduce;

        return round($taxable * $taxPercentage, 0, PHP_ROUND_HALF_DOWN) / 12; //Potongan pajak sebulan
    }
}
