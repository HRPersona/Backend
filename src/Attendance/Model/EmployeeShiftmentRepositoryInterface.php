<?php

namespace Persona\Hris\Attendance\Model;

use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Repository\RepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface EmployeeShiftmentRepositoryInterface extends RepositoryInterface
{
    /**
     * @param EmployeeInterface $employee
     * @param \DateTime         $attendanceDate
     *
     * @return bool
     */
    public function isTimeOff(EmployeeInterface $employee, \DateTime $attendanceDate): bool;
}
