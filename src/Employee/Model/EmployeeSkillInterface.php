<?php

namespace Persona\Hris\Employee\Model;
use Persona\Hris\Share\Model\SkillInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface EmployeeSkillInterface
{
    const LEVEL_BEGINNER = 'b';
    const LEVEL_INTERMEDIATE = 'i';
    const LEVEL_ADVANCED = 'a';
    const LEVEL_EXPERT = 'e';

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
     * @return SkillInterface
     */
    public function getSkill():? SkillInterface;

    /**
     * @param SkillInterface $skill
     */
    public function setSkill(SkillInterface $skill): void;

    /**
     * @return string
     */
    public function getLevel(): string;
}
