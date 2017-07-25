<?php

namespace Persona\Hris\Overtime\Model;

use Persona\Hris\Repository\CachableRepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface HolidayRepositoryInterface extends CachableRepositoryInterface
{
    /**
     * @param \DateTime $date
     *
     * @return bool
     */
    public function isTimeOff(\DateTime $date): bool;
}
