<?php

namespace Persona\Hris\Overtime\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface HolidayInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return \DateTime
     */
    public function getHolidayDate(): \DateTime;
}
