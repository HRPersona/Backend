<?php

namespace Persona\Hris\Employee\Model;

use Persona\Hris\Course\Model\CourseInterface;
use Persona\Hris\Repository\RepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface EmployeeCourseRepositoryInterface extends RepositoryInterface
{
    /**
     * @param EmployeeInterface $employee
     * @param CourseInterface   $course
     *
     * @return EmployeeCourseInterface
     */
    public function createNew(EmployeeInterface $employee, CourseInterface $course): EmployeeCourseInterface;

    /**
     * @param EmployeeInterface $employee
     * @param CourseInterface   $course
     *
     * @return null|EmployeeCourseInterface
     */
    public function findByEmployeeCourse(EmployeeInterface $employee, CourseInterface $course): ? EmployeeCourseInterface;
}
