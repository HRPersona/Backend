<?php

namespace Persona\Hris\Performance\Model;

use Persona\Hris\Employee\Model\EmployeeInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface EmployeeSkillAppraisalDetailInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return null|EmployeeSkillAppraisalInterface
     */
    public function getEmployeeSkillAppraisal(): ? EmployeeSkillAppraisalInterface;

    /**
     * @param EmployeeSkillAppraisalInterface $employeeSkillAppraisal
     */
    public function setEmployeeSkillAppraisal(EmployeeSkillAppraisalInterface $employeeSkillAppraisal): void;

    /**
     * @return null|EmployeeInterface
     */
    public function getSelfAppraisalBy(): ? EmployeeInterface;

    /**
     * @param EmployeeInterface $employee
     */
    public function setSelfAppraisalBy(EmployeeInterface $employee): void;

    /**
     * @return null|EmployeeInterface
     */
    public function getFirstSupervisorAppraisalBy(): ? EmployeeInterface;

    /**
     * @param EmployeeInterface $employee
     */
    public function setFirstSupervisorAppraisalBy(EmployeeInterface $employee): void;

    /**
     * @return null|EmployeeInterface
     */
    public function getSecondSupervisorAppraisalBy(): ? EmployeeInterface;

    /**
     * @param EmployeeInterface $employee
     */
    public function setSecondSupervisorAppraisalBy(EmployeeInterface $employee): void;

    /**
     * @return string
     */
    public function getSelfAppraisal(): string;

    /**
     * @return string
     */
    public function getFirstSupervisorAppraisal(): string;

    /**
     * @return string
     */
    public function getSecondSupervisorAppraisal(): string;

    /**
     * @return string
     */
    public function getSelfAppraisalComment(): string;

    /**
     * @return string
     */
    public function getFirstSupervisorAppraisalComment(): string;

    /**
     * @return string
     */
    public function getSecondSupervisorAppraisalComment(): string;
}
