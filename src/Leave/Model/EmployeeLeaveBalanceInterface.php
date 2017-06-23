<?php

namespace Persona\Hris\Leave\Model;

use Persona\Hris\Employee\Model\EmployeeInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface EmployeeLeaveBalanceInterface
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
     * @return int
     */
    public function getLeaveDay(): int;

    /**
     * @param int $leaveDay
     */
    public function setLeaveDay(int $leaveDay): void;

    /**
     * @return int
     */
    public function getLeaveBalance(): int;

    /**
     * @param int $leaveBalance
     */
    public function setLeaveBalance(int $leaveBalance): void;

    /**
     * @return string
     */
    public function getRemark(): string;

    /**
     * @param string $remark
     */
    public function setRemark(string $remark): void;
}