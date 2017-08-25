<?php

namespace Persona\Hris\Allocation\Model;

use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Organization\Model\CompanyInterface;
use Persona\Hris\Organization\Model\DepartmentInterface;
use Persona\Hris\Organization\Model\JobClassInterface;
use Persona\Hris\Organization\Model\JobTitleInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface JobAllocationInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return null|EmployeeInterface
     */
    public function getEmployee(): ? EmployeeInterface;

    /**
     * @param EmployeeInterface $employee
     */
    public function setEmployee(EmployeeInterface $employee = null): void;

    /**
     * @return null|JobTitleInterface
     */
    public function getJobTitle(): ? JobTitleInterface;

    /**
     * @param JobTitleInterface $jobTitle
     */
    public function setJobTitle(JobTitleInterface $jobTitle = null): void;

    /**
     * @return null|JobClassInterface
     */
    public function getJobClass(): ? JobClassInterface;

    /**
     * @param JobClassInterface $jobClass
     */
    public function setJobClass(JobClassInterface $jobClass = null): void;

    /**
     * @return null|CompanyInterface
     */
    public function getCompany(): ? CompanyInterface;

    /**
     * @param CompanyInterface $company
     */
    public function setCompany(CompanyInterface $company = null): void;

    /**
     * @return null|DepartmentInterface
     */
    public function getDepartment(): ? DepartmentInterface;

    /**
     * @param DepartmentInterface $department
     */
    public function setDepartment(DepartmentInterface $department = null): void;

    /**
     * @return \DateTime
     */
    public function getStartDate(): \DateTime;

    /**
     * @return \DateTime|null
     */
    public function getEndDate(): ? \DateTime;

    /**
     * @return string
     */
    public function getLetterNumber(): string;

    /**
     * @return bool
     */
    public function isActive(): bool;
}
