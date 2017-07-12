<?php

namespace Persona\Hris\Overtime\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface HolidayRepositoryInterface
{
    /**
     * @param \DateTime $date
     *
     * @return bool
     */
    public function isTimeOff(\DateTime $date): bool;
}
