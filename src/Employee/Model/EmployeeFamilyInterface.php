<?php

namespace Persona\Hris\Employee\Model;

use Persona\Hris\Share\Model\CityInterface;
use Persona\Hris\Share\Model\EducationTitleInterface;
use Persona\Hris\Share\Model\UniversityInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface EmployeeFamilyInterface
{
    const RELATION_PARENT = 'o';
    const RELATION_COUPLE = 's';
    const RELATION_SON = 'a';

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
     * @return string
     */
    public function getRelationShip(): string;

    /**
     * @return string
     */
    public function getFullName(): string;

    /**
     * @return null|CityInterface
     */
    public function getPlaceOfBirth(): ? CityInterface;

    /**
     * @param CityInterface $city
     */
    public function setPlaceOfBirth(CityInterface $city): void;

    /**
     * @return \DateTime
     */
    public function getDateOfBirth(): \DateTime;

    /**
     * @return null|UniversityInterface
     */
    public function getUniversity(): ? UniversityInterface;

    /**
     * @param UniversityInterface $university
     */
    public function setUniversity(UniversityInterface $university): void;

    /**
     * @return null|EducationTitleInterface
     */
    public function getEducationTitle(): ? EducationTitleInterface;

    /**
     * @param EducationTitleInterface $educationTitle
     */
    public function setEducationTitle(EducationTitleInterface $educationTitle): void;
}
