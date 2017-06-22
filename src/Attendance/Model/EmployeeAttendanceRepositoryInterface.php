<?php

namespace Persona\Hris\Attendance\Model;

use Persona\Hris\Employee\Model\EmployeeInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface EmployeeAttendanceRepositoryInterface
{
    /**
     * @param EmployeeInterface $employee
     * @param \DateTime $attendanceDate
     *
     * @return null|EmployeeAttendanceInterface
     */
    public function findByEmployeeAndDate(EmployeeInterface $employee, \DateTime $attendanceDate):? EmployeeAttendanceInterface;
}
