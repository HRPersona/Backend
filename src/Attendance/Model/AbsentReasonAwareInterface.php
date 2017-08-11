<?php

namespace Persona\Hris\Attendance\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface AbsentReasonAwareInterface
{
    /**
     * @return string
     */
    public function getAbsentReasonId(): string;

    /**
     * @param string|null $absentReason
     */
    public function setAbsentReasonId(string $absentReason = null);

    /**
     * @return null|AbsentReasonInterface
     */
    public function getAbsentReason(): ? AbsentReasonInterface;

    /**
     * @param AbsentReasonInterface|null $absentReason
     */
    public function setAbsentReason(AbsentReasonInterface $absentReason = null): void;
}
