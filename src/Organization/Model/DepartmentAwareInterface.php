<?php

namespace Persona\Hris\Organization\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface DepartmentAwareInterface
{
    /**
     * @return string
     */
    public function getDepartmentId(): string;

    /**
     * @param string|null $department
     */
    public function setDepartmentId(string $department = null);

    /**
     * @return null|DepartmentInterface
     */
    public function getDepartment(): ? DepartmentInterface;

    /**
     * @param DepartmentInterface|null $department
     */
    public function setDepartment(DepartmentInterface $department = null): void;
}
