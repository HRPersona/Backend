<?php

namespace Persona\Hris\Leave\Model;

use Persona\Hris\Attendance\Model\AbsentReasonInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface LeaveInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return null|AbsentReasonInterface
     */
    public function getAbsentReason(): ? AbsentReasonInterface;

    /**
     * @param AbsentReasonInterface $absentReason
     */
    public function setAbsentReason(AbsentReasonInterface $absentReason = null): void;

    /**
     * @return string
     */
    public function getCode(): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return int
     */
    public function getDayBenefit(): ? int;
}
