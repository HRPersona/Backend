<?php

namespace Persona\Hris\Performance\Model;

use Persona\Hris\Employee\Model\EmployeeInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface EmployeeIndicatorAppraisalInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return null|EmployeeInterface
     */
    public function getEmployee(): ? EmployeeInterface;

    /**
     * @param EmployeeInterface $employee
     */
    public function setEmployee(EmployeeInterface $employee): void;

    /**
     * @return null|AppraisalPeriodInterface
     */
    public function getAppraisalPeriod(): ? AppraisalPeriodInterface;

    /**
     * @param AppraisalPeriodInterface $appraisalPeriod
     */
    public function setAppraisalPeriod(AppraisalPeriodInterface $appraisalPeriod): void;

    /**
     * @return \DateTime
     */
    public function getInputDate(): \DateTime;

    /**
     * @return null|IndicatorInterface
     */
    public function getIndicator(): ? IndicatorInterface;

    /**
     * @param IndicatorInterface $indicator
     */
    public function setIndicator(IndicatorInterface $indicator): void;
}
