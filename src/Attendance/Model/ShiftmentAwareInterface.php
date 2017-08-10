<?php

namespace Persona\Hris\Attendance\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface ShiftmentAwareInterface
{
    /**
     * @return string
     */
    public function getShiftmentId(): string;

    /**
     * @param string|null $module
     */
    public function setShiftmentId(string $module = null);

    /**
     * @return null|ShiftmentInterface
     */
    public function getShiftment(): ? ShiftmentInterface;

    /**
     * @param ShiftmentInterface|null $module
     */
    public function setShiftment(ShiftmentInterface $module = null): void;
}
