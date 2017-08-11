<?php

namespace Persona\Hris\Organization\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface ParentDepartmentAwareInterface
{
    /**
     * @return string
     */
    public function getParentId(): string;

    /**
     * @param string|null $department
     */
    public function setParentId(string $department = null);

    /**
     * @return null|DepartmentInterface
     */
    public function getParent(): ? DepartmentInterface;

    /**
     * @param DepartmentInterface|null $department
     */
    public function setParent(DepartmentInterface $department = null): void;
}
