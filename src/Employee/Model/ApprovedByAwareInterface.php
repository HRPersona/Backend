<?php

namespace Persona\Hris\Employee\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface ApprovedByAwareInterface
{
    /**
     * @return string
     */
    public function getApprovedById(): string;

    /**
     * @param string|null $employee
     */
    public function setApprovedById(string $employee = null);

    /**
     * @return null|EmployeeInterface
     */
    public function getApprovedBy(): ? EmployeeInterface;

    /**
     * @param EmployeeInterface|null $employee
     */
    public function setApprovedBy(EmployeeInterface $employee = null): void;
}
