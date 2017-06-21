<?php

namespace Persona\Hris\Employee\Model;

use Persona\Hris\Organization\Model\CompanyInterface;
use Persona\Hris\Organization\Model\JobTitleInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface MutationInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return null|EmployeeInterface
     */
    public function getEmployee():? EmployeeInterface;

    /**
     * @param EmployeeInterface $employee
     */
    public function setEmployee(EmployeeInterface $employee): void;

    /**
     * @return null|JobTitleInterface
     */
    public function getOldJobTitle():? JobTitleInterface;

    /**
     * @param JobTitleInterface $jobTitle
     */
    public function setOldJobTitle(JobTitleInterface $jobTitle): void;

    /**
     * @return null|JobTitleInterface
     */
    public function getNewJobTitle():? JobTitleInterface;

    /**
     * @param JobTitleInterface $jobTitle
     */
    public function setNewJobTitle(JobTitleInterface $jobTitle): void;

    /**
     * @return null|CompanyInterface
     */
    public function getOldCompany():? CompanyInterface;

    /**
     * @param CompanyInterface $company
     */
    public function setOldCompany(CompanyInterface $company): void;

    /**
     * @return null|CompanyInterface
     */
    public function getNewCompany():? CompanyInterface;

    /**
     * @param CompanyInterface $company
     */
    public function setNewCompany(CompanyInterface $company): void;

    /**
     * @return \DateTime
     */
    public function getStartDate(): \DateTime;

    /**
     * @return string
     */
    public function getLetterNumber(): string;
}
