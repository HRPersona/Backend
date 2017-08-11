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
     * @param string|null $shiftment
     */
    public function setShiftmentId(string $shiftment = null);

    /**
     * @return null|ShiftmentInterface
     */
    public function getShiftment(): ? ShiftmentInterface;

    /**
     * @param ShiftmentInterface|null $shiftment
     */
    public function setShiftment(ShiftmentInterface $shiftment = null): void;
}
