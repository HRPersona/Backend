<?php

namespace Persona\Hris\Attendance\Model;

use Persona\Hris\Employee\Model\EmployeeInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface EmployeeAttendanceRepositoryInterface
{
    /**
     * When record is not found then create new object.
     *
     * @param EmployeeInterface $employee
     * @param \DateTime         $attendanceDate
     *
     * @return EmployeeAttendanceInterface
     */
    public function findByEmployeeAndDate(EmployeeInterface $employee, \DateTime $attendanceDate): EmployeeAttendanceInterface;
}
