<?php

namespace Persona\Hris\Leave\Model;

use Persona\Hris\Employee\Model\EmployeeInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface EmployeeLeaveInterface
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
    public function getLeaveDate(): \DateTime;

    /**
     * @return null|LeaveInterface
     */
    public function getLeave(): ? LeaveInterface;

    /**
     * @param LeaveInterface $leave
     */
    public function setLeave(LeaveInterface $leave): void;

    /**
     * @return int
     */
    public function getLeaveDay(): int;

    /**
     * @return string
     */
    public function getRemark(): string;

    /**
     * @return bool
     */
    public function isApproved(): bool;

    /**
     * @param bool $approved
     */
    public function setApproved(bool $approved): void;

    /**
     * @return null|EmployeeInterface
     */
    public function getApprovedBy(): ? EmployeeInterface;

    /**
     * @param EmployeeInterface $employee
     */
    public function setApprovedBy(EmployeeInterface $employee): void;
}
