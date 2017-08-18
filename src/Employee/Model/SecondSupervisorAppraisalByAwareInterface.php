<?php

namespace Persona\Hris\Employee\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface SecondSupervisorAppraisalByAwareInterface
{
    /**
     * @return string
     */
    public function getSecondSupervisorAppraisalById(): string;

    /**
     * @param string|null $employee
     */
    public function setSecondSupervisorAppraisalById(string $employee = null);

    /**
     * @return null|EmployeeInterface
     */
    public function getSecondSupervisorAppraisalBy(): ? EmployeeInterface;

    /**
     * @param EmployeeInterface|null $employee
     */
    public function setSecondSupervisorAppraisalBy(EmployeeInterface $employee = null): void;
}
