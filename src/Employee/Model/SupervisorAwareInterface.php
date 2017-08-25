<?php

namespace Persona\Hris\Employee\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface SupervisorAwareInterface
{
    /**
     * @return string
     */
    public function getSupervisorId(): string;

    /**
     * @param string|null $employee
     */
    public function setSupervisorId(string $employee = null);

    /**
     * @return null|EmployeeInterface
     */
    public function getSupervisor(): ? EmployeeInterface;

    /**
     * @param EmployeeInterface|null $employee
     */
    public function setSupervisor(EmployeeInterface $employee = null): void;
}
