<?php

namespace Persona\Hris\Insurance\Formula\Jp;

use Persona\Hris\Insurance\Formula\AbstractCost;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
class EmployeeCost extends AbstractCost
{
    /**
     * @return float|null
     */
    public function getPercentageValue(): ? float
    {
        return 0.01;
    }

    /**
     * @return float|null
     */
    public function getFixedValue(): ? float
    {
        return 0;
    }
}
