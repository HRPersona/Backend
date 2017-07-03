<?php

namespace Persona\Hris\Organization\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface CompanyDepartmentInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return CompanyInterface
     */
    public function getCompany(): CompanyInterface;

    /**
     * @param CompanyInterface $company
     */
    public function setCompany(CompanyInterface $company = null): void;

    /**
     * @return DepartmentInterface
     */
    public function getDepartment(): DepartmentInterface;

    /**
     * @param DepartmentInterface $department
     */
    public function setDepartment(DepartmentInterface $department = null): void;
}
