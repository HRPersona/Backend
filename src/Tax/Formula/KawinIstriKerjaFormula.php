<?php

namespace Persona\Hris\Tax\Formula;

use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Salary\Model\PayrollInterface;
use Persona\Hris\Tax\TaxPercentage;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
class KawinIstriKerjaFormula extends AbstractTaxFormula
{
    const KI0 = 112500000;
    const KI1 = 117000000;
    const KI2 = 121500000;
    const KI3 = 126000000;

    /**
     * @param PayrollInterface $payroll
     *
     * @return float
     */
    public function getCalculatedValue(PayrollInterface $payroll): float
    {
        $taxable = 12 * $this->getTaxableValue($payroll); //Penghasilan netto setahun
        $taxPercentage = TaxPercentage::getPercentageValue($taxable); //Persentase pajak berdasarkan netto

        $taxReduce = self::KI0; //PTKP
        switch ($payroll->getEmployee()->getTaxGroup()) {
            case EmployeeInterface::TAX_KI_1:
                $taxReduce = self::KI1;
                break;
            case EmployeeInterface::TAX_KI_2:
                $taxReduce = self::KI2;
                break;
            case EmployeeInterface::TAX_KI_3:
                $taxReduce = self::KI3;
                break;
        }

        $taxable = $taxable - $taxReduce;

        return round($taxable * $taxPercentage, 0, PHP_ROUND_HALF_DOWN) / 12; //Potongan pajak sebulan
    }
}
