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
     * @param string|null $employee
     */
    public function setEmployeeId(string $employee = null);

    /**
     * @return null|EmployeeInterface
     */
    public function getEmployee(): ? EmployeeInterface;

    /**
     * @param EmployeeInterface|null $employee
     */
    public function setEmployee(EmployeeInterface $employee = null): void;
}
