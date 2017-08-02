<?php

namespace Persona\Hris\Insurance\Formula\Jht;

use Persona\Hris\Insurance\Formula\AbstractCost;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
class CompanyCost extends AbstractCost
{
    /**
     * @return float|null
     */
    public function getPercentageValue(): ? float
    {
        return 0.037;
    }

    /**
     * @return float|null
     */
    public function getFixedValue(): ? float
    {
        return 0;
    }
}
