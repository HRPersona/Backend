<?php

namespace Persona\Hris\Organization\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface OldDepartmentAwareInterface
{
    /**
     * @return string
     */
    public function getOldDepartmentId(): string;

    /**
     * @param string|null $department
     */
    public function setOldDepartmentId(string $department = null);

    /**
     * @return null|DepartmentInterface
     */
    public function getOldDepartment(): ? DepartmentInterface;

    /**
     * @param DepartmentInterface|null $department
     */
    public function setOldDepartment(DepartmentInterface $department = null): void;
}
