<?php

namespace Persona\Hris\Employee\Model;

use Persona\Hris\Share\Model\SkillInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface EmployeeSkillInterface
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
     * @return SkillInterface
     */
    public function getSkill(): ? SkillInterface;

    /**
     * @param SkillInterface $skill
     */
    public function setSkill(SkillInterface $skill = null): void;

    /**
     * @return string
     */
    public function getLevel(): string;
}
