<?php

namespace Persona\Hris\Overtime\Model;

use Persona\Hris\Employee\Model\EmployeeInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface EmployeeOvertimeInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return null|EmployeeInterface
     */
    public function getProposedBy(): ? EmployeeInterface;

    /**
     * @param EmployeeInterface $employee
     */
    public function setProposedBy(EmployeeInterface $employee = null): void;

    /**
     * @return null|EmployeeInterface
     */
    public function getEmployee(): ? EmployeeInterface;

    /**
     * @param EmployeeInterface $employee
     */
    public function setEmployee(EmployeeInterface $employee = null): void;

    /**
     * @return \DateTime
     */
    public function getOvertimeDate(): \DateTime;

    /**
     * @return float
     */
    public function getOvertimeValue(): float;

    /**
     * @return bool
     */
    public function isOffTime(): bool;

    /**
     * @return null|string
     */
    public function getRemark(): ? string;
}
