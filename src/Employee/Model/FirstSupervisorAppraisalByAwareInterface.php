<?php

namespace Persona\Hris\Employee\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface FirstSupervisorAppraisalByAwareInterface
{
    /**
     * @return string
     */
    public function getFirstSupervisorAppraisalById(): string;

    /**
     * @param string|null $employee
     */
    public function setFirstSupervisorAppraisalById(string $employee = null);

    /**
     * @return null|EmployeeInterface
     */
    public function getFirstSupervisorAppraisalBy(): ? EmployeeInterface;

    /**
     * @param EmployeeInterface|null $employee
     */
    public function setFirstSupervisorAppraisalBy(EmployeeInterface $employee = null): void;
}
