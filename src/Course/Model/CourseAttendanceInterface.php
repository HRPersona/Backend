<?php

namespace Persona\Hris\Course\Model;

use Persona\Hris\Employee\Model\EmployeeInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface CourseAttendanceInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return null|CourseInterface
     */
    public function getCourse(): ? CourseInterface;

    /**
     * @param CourseInterface|null $course
     */
    public function setCourse(CourseInterface $course = null): void;

    /**
     * @return null|EmployeeInterface
     */
    public function getEmployee(): ? EmployeeInterface;

    /**
     * @param EmployeeInterface $employee
     */
    public function setEmployee(EmployeeInterface $employee = null): void;

    /**
     * @return string
     */
    public function getCertificateNumber(): string;

    /**
     * @return string
     */
    public function getCertificateFile(): ? string;
}
