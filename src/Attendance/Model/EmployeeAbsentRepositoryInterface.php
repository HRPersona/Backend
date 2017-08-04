<?php

namespace Persona\Hris\Attendance\Model;

use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Repository\RepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface EmployeeAbsentRepositoryInterface extends RepositoryInterface
{
    /**
     * When record is not found then create new object.
     *
     * @param EmployeeInterface $employee
     * @param \DateTime         $absentDate
     *
     * @return EmployeeAbsentInterface
     */
    public function findByEmployeeAndDate(EmployeeInterface $employee, \DateTime $absentDate): EmployeeAbsentInterface;
}
