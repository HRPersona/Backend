<?php

namespace Persona\Hris\Overtime\Model;

use Persona\Hris\Employee\Model\EmployeeInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface EmployeeOvertimeHistoryInterface
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
     * @return int
     */
    public function getOvertimeYear(): int;

    /**
     * @param int $year
     */
    public function setOvertimeYear(int $year): void;

    /**
     * @return int
     */
    public function getOvertimeMonth(): int;

    /**
     * @param int $month
     */
    public function setOvertimeMonth(int $month): void;

    /**
     * @return float
     */
    public function getCalculatedValue(): float;

    /**
     * @param float $calculatedValue
     */
    public function setCalculatedValue(float $calculatedValue): void;

    /**
     * @return bool
     */
    public function isClosed(): bool;

    /**
     * @param bool $closed
     */
    public function setClosed(bool $closed): void;
}
