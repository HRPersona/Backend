<?php

namespace Persona\Hris\Performance\Model;

use Persona\Hris\Employee\Model\EmployeeInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface SupervisorAwareInterface
{
    /**
     * @return null|EmployeeInterface
     */
    public function getEmployee(): ? EmployeeInterface;

    /**
     * @return null|EmployeeInterface
     */
    public function getFirstSupervisorAppraisalBy(): ? EmployeeInterface;

    /**
     * @param EmployeeInterface $employee
     */
    public function setFirstSupervisorAppraisalBy(EmployeeInterface $employee = null): void;

    /**
     * @return null|EmployeeInterface
     */
    public function getSecondSupervisorAppraisalBy(): ? EmployeeInterface;

    /**
     * @param EmployeeInterface $employee
     */
    public function setSecondSupervisorAppraisalBy(EmployeeInterface $employee = null): void;
}
