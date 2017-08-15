<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Course\Model\CourseInterface;
use Persona\Hris\Employee\Model\EmployeeCourseInterface;
use Persona\Hris\Employee\Model\EmployeeCourseRepositoryInterface;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Repository\AbstractRepository;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class EmployeeCourseRepository extends AbstractRepository implements EmployeeCourseRepositoryInterface
{
    /**
     * @param ManagerFactory $managerFactory
     * @param string         $class
     */
    public function __construct(ManagerFactory $managerFactory, string  $class)
    {
        parent::__construct($managerFactory, $class);
    }

    /**
     * @param EmployeeInterface $employee
     * @param CourseInterface   $course
     *
     * @return EmployeeCourseInterface
     */
    public function createNew(EmployeeInterface $employee, CourseInterface $course): EmployeeCourseInterface
    {
        /** @var EmployeeCourseInterface $employeeCourse */
        $employeeCourse = new $this->class();
        $employeeCourse->setEmployee($employee);
        $employeeCourse->setUniversity($course->getUniversity());

        return $employeeCourse;
    }

    /**
     * @param EmployeeInterface $employee
     * @param CourseInterface   $course
     *
     * @return null|EmployeeCourseInterface
     */
    public function findByEmployeeCourse(EmployeeInterface $employee, CourseInterface $course): ? EmployeeCourseInterface
    {
        return $this->managerFactory->getReadManager()->getRepository($this->class)->findOneBy([
            'employee' => $employee,
            'course' => $course,
            'deletedAt' => null,
        ]);
    }
}
