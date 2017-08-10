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
     * @param string|null $module
     */
    public function setAbsentReasonId(string $module = null);

    /**
     * @return null|AbsentReasonInterface
     */
    public function getAbsentReason(): ? AbsentReasonInterface;

    /**
     * @param AbsentReasonInterface|null $module
     */
    public function setAbsentReason(AbsentReasonInterface $module = null): void;
}
