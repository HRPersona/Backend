<?php

namespace Persona\Hris\Employee\Model;

use Persona\Hris\Share\Model\UniversityInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface EmployeeTrainingInterface
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
     * @return \DateTime
     */
    public function getStartDate(): \DateTime;

    /**
     * @return \DateTime
     */
    public function getEndDate(): \DateTime;

    /**
     * @return null|UniversityInterface
     */
    public function getUniversity(): ? UniversityInterface;

    /**
     * @param UniversityInterface $university
     */
    public function setUniversity(UniversityInterface $university = null): void;

    /**
     * @return string
     */
    public function getCerficateNumber(): string;

    /**
     * @return string
     */
    public function getCerfiticateFile(): ? string;
}
