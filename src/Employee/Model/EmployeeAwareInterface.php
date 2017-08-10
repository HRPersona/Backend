<?php

namespace Persona\Hris\Employee\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface EmployeeAwareInterface
{
    /**
     * @return string
     */
    public function getEmployeeId(): string;

    /**
     * @param string|null $module
     */
    public function setEmployeeId(string $module = null);

    /**
     * @return null|EmployeeInterface
     */
    public function getEmployee(): ? EmployeeInterface;

    /**
     * @param EmployeeInterface|null $module
     */
    public function setEmployee(EmployeeInterface $module = null): void;
}
