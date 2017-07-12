<?php

namespace Persona\Hris\Attendance\Model;

use Persona\Hris\Employee\Model\EmployeeInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface EmployeeShiftmentRepositoryInterface
{
    /**
     * @param EmployeeInterface $employee
     * @param \DateTime         $attendanceDate
     *
     * @return bool
     */
    public function isTimeOff(EmployeeInterface $employee, \DateTime $attendanceDate): bool;
}
