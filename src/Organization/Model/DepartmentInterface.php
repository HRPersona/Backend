<?php

namespace Persona\Hris\Organization\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface DepartmentInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return DepartmentInterface
     */
    public function getParent(): ? DepartmentInterface;

    /**
     * @param DepartmentInterface $department
     */
    public function setParent(DepartmentInterface $department = null): void;

    /**
     * @return string
     */
    public function getCode(): string;

    /**
     * @return string
     */
    public function getName(): string;
}
