<?php

namespace Persona\Hris\Attendance\Model;

use Persona\Hris\Employee\Model\EmployeeInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface EmployeeAttendanceInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return null|EmployeeInterface
     */
    public function getEmployee(): ? EmployeeInterface;

    /**
     * @param EmployeeInterface $employee
     */
    public function setEmployee(EmployeeInterface $employee = null): void;

    /**
     * @return null|ShiftmentInterface
     */
    public function getShiftment(): ? ShiftmentInterface;

    /**
     * @param ShiftmentInterface $shiftment
     */
    public function setShiftment(ShiftmentInterface $shiftment = null): void;

    /**
     * @return \DateTime
     */
    public function getAttendanceDate(): \DateTime;

    /**
     * @return string
     */
    public function getTimeIn(): string;

    /**
     * @return string
     */
    public function getTimeOut(): string;

    /**
     * @return string
     */
    public function getEarlyIn(): string;

    /**
     * @param string $earlyIn
     */
    public function setEarlyIn(string $earlyIn): void;

    /**
     * @return string
     */
    public function getEarlyOut(): string;

    /**
     * @param string $earlyOut
     */
    public function setEarlyOut(string $earlyOut): void;

    /**
     * @return string
     */
    public function getLateIn(): string;

    /**
     * @param string $lateIn
     */
    public function setLateIn(string $lateIn): void;

    /**
     * @return string
     */
    public function getLateOut(): string;

    /**
     * @param string $lateOut
     */
    public function setLateOut(string $lateOut): void;

    /**
     * @return bool
     */
    public function isAbsent(): bool;

    /**
     * @param bool $isAbsent
     */
    public function setAbsent(bool $isAbsent): void;

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
    public function getRemark(): ? string;

    /**
     * @param string $remark
     */
    public function setRemark(string $remark = null): void;
}
