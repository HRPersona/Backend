<?php

namespace Persona\Hris\Overtime\Model;

use Persona\Hris\Repository\RepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface HolidayRepositoryInterface extends RepositoryInterface
{
    /**
     * @param \DateTime $date
     *
     * @return bool
     */
    public function isTimeOff(\DateTime $date): bool;
}
