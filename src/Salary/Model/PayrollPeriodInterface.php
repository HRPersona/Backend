<?php

namespace Persona\Hris\Salary\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface PayrollPeriodInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getPayrollYear(): string;

    /**
     * @return string
     */
    public function getPayrollMonth(): string;

    /**
     * @return bool
     */
    public function isActive(): bool;

    /**
     * @param bool $isActive
     */
    public function setActive(bool $isActive): void;
}
