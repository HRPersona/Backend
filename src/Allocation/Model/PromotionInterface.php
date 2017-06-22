<?php

namespace Persona\Hris\Employee\Model;

use Persona\Hris\Organization\Model\JobTitleInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface PromotionInterface
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
    public function setEmployee(EmployeeInterface $employee): void;

    /**
     * @return null|JobTitleInterface
     */
    public function getOldJobTitle(): ? JobTitleInterface;

    /**
     * @param JobTitleInterface $jobTitle
     */
    public function setOldJobTitle(JobTitleInterface $jobTitle): void;

    /**
     * @return null|JobTitleInterface
     */
    public function getNewJobTitle(): ? JobTitleInterface;

    /**
     * @param JobTitleInterface $jobTitle
     */
    public function setNewJobTitle(JobTitleInterface $jobTitle): void;

    /**
     * @return \DateTime
     */
    public function getStartDate(): \DateTime;

    /**
     * @return string
     */
    public function getLetterNumber(): string;
}
