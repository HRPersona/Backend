<?php

namespace Persona\Hris\Attendance\Model;

use Persona\Hris\Employee\Model\EmployeeInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface EmployeeAbsentInterface
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
    public function setEmployee(EmployeeInterface $employee): void;

    /**
     * @return \DateTime
     */
    public function getAbsentDate(): \DateTime;

    /**
     * @return null|AbsentReasonInterface
     */
    public function getAbsentReason(): ? AbsentReasonInterface;

    /**
     * @param AbsentReasonInterface $absentReason
     */
    public function setAbsentReason(AbsentReasonInterface $absentReason): void;

    /**
     * @return string
     */
    public function getRemark(): ? string;

    /**
     * @param string $remark
     */
    public function setRemark(string $remark): void;
}
