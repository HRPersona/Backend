<?php

namespace Persona\Hris\Tax\Formula;

use Persona\Hris\Employee\Model\EmployeeInterface;
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
     * @param EmployeeInterface $employee
     *
     * @return float
     */
    public function getCalculatedValue(EmployeeInterface $employee): float
    {
        $taxable = $this->getTaxableValue($employee);
        $taxPercentage = TaxPercentage::getPercentageValue($taxable);

        $taxReduce = self::KI0;
        switch ($employee->getTaxGroup()) {
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

        return $taxable * $taxPercentage;
    }
}
