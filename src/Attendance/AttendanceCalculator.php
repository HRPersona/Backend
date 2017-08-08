<?php

namespace Persona\Hris\Attendance;
use Persona\Hris\Attendance\Model\EmployeeAttendanceInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class AttendanceCalculator
{
    /**
     * @param EmployeeAttendanceInterface $employeeAttendance
     */
    public static function calculate(EmployeeAttendanceInterface $employeeAttendance): void
    {
        $now = new \DateTime();

        $timeIn = \DateTime::createFromFormat('Y-m-d H:i:s', sprintf('%s %s', $now->format('Y-m-d'), $employeeAttendance->getTimeIn()));
        $timeOut = \DateTime::createFromFormat('Y-m-d H:i:s', sprintf('%s %s', $now->format('Y-m-d'), $employeeAttendance->getTimeOut()));

        $shiftment = $employeeAttendance->getShiftment();
        if ($shiftment) {
            $workHourStart = \DateTime::createFromFormat('Y-m-d H:i:s', sprintf('%s %s:%s:00', $now->format('Y-m-d'), $shiftment->getStartHour(), $shiftment->getStartMinute()));
            $workHourEnd = \DateTime::createFromFormat('Y-m-d H:i:s', sprintf('%s %s:%s:00', $now->format('Y-m-d'), $shiftment->getEndHour(), $shiftment->getEndMinute()));

            if ($timeIn <= $workHourStart) {
                $employeeAttendance->setEarlyIn($workHourStart->diff($timeIn, true)->format('H:i'));
            } else {
                $employeeAttendance->setLateIn($timeIn->diff($workHourStart, true)->format('H:i'));
            }

            if ($timeOut >= $workHourEnd) {
                $employeeAttendance->setLateOut($timeOut->diff($workHourEnd, true)->format('H:i'));
            } else {
                $employeeAttendance->setLateIn($workHourEnd->diff($timeOut, true)->format('H:i'));
            }
        }
    }
}
