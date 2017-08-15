<?php

namespace Persona\Hris\Organization\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface NewDepartmentAwareInterface
{
    /**
     * @return string
     */
    public function getNewDepartmentId(): string;

    /**
     * @param string|null $department
     */
    public function setNewDepartmentId(string $department = null);

    /**
     * @return null|DepartmentInterface
     */
    public function getNewDepartment(): ? DepartmentInterface;

    /**
     * @param DepartmentInterface|null $department
     */
    public function setNewDepartment(DepartmentInterface $department = null): void;
}
