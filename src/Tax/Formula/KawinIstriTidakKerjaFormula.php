<?php

namespace Persona\Hris\Tax\Formula;

use Persona\Hris\Employee\Model\EmployeeInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
class KawinIstriTidakKerjaFormula extends AbstractTaxFormula
{
    /**
     * @param EmployeeInterface $employee
     *
     * @return float
     */
    public function getCalculatedValue(EmployeeInterface $employee): float
    {
        // TODO: Implement getCalculatedValue() method.
    }
}
