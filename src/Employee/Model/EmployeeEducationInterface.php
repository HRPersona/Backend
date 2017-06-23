<?php

namespace Persona\Hris\Employee\Model;

use Persona\Hris\Share\Model\EducationTitleInterface;
use Persona\Hris\Share\Model\UniversityInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface EmployeeEducationInterface
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
     * @return int
     */
    public function getStartYear(): int;

    /**
     * @return int
     */
    public function getEndYear(): int;

    /**
     * @return null|UniversityInterface
     */
    public function getUniversity(): ? UniversityInterface;

    /**
     * @param UniversityInterface $university
     */
    public function setUniversity(UniversityInterface $university = null): void;

    /**
     * @return null|EducationTitleInterface
     */
    public function getEducationTitle(): ? EducationTitleInterface;

    /**
     * @param EducationTitleInterface $educationTitle
     */
    public function setEducationTitle(EducationTitleInterface $educationTitle = null): void;

    /**
     * @return bool
     */
    public function isGraduated(): bool;
}
