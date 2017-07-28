<?php

namespace Persona\Hris\Tax\Formula;

use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Salary\Model\PayrollInterface;
use Persona\Hris\Tax\TaxPercentage;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
class KawinIstriTidakKerjaFormula extends AbstractTaxFormula
{
    const K0 = 58500000;
    const K1 = 63000000;
    const K2 = 67500000;
    const K3 = 72000000;

    /**
     * @param PayrollInterface $payroll
     *
     * @return float
     */
    public function getCalculatedValue(PayrollInterface $payroll): float
    {
        $taxable = 12 * $this->getTaxableValue($payroll); //Penghasilan netto setahun
        $taxPercentage = TaxPercentage::getPercentageValue($taxable); //Persentase pajak berdasarkan netto

        $taxReduce = self::K0; //PTKP
        switch ($payroll->getEmployee()->getTaxGroup()) {
            case EmployeeInterface::TAX_K_1:
                $taxReduce = self::K1;
                break;
            case EmployeeInterface::TAX_K_2:
                $taxReduce = self::K2;
                break;
            case EmployeeInterface::TAX_K_3:
                $taxReduce = self::K3;
                break;
        }

        $taxable = $taxable - $taxReduce;

        return round($taxable * $taxPercentage, 0, PHP_ROUND_HALF_DOWN) / 12; //Potongan pajak sebulan
    }
}
