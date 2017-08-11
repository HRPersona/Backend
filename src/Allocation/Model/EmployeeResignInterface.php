<?php

namespace Persona\Hris\Allocation\Model;

use Persona\Hris\Employee\Model\EmployeeInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface EmployeeResignInterface
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
    public function setEmployee(EmployeeInterface $employee = null): void;

    /**
     * @return \DateTime
     */
    public function getAbsentDate(): \DateTime;

    /**
     * @param \DateTime $resignDate
     */
    public function setAbsentDate(\DateTime $resignDate): void;

    /**
     * @return null|ResignReasonInterface
     */
    public function getResignReason(): ? ResignReasonInterface;

    /**
     * @param ResignReasonInterface $resignReason
     */
    public function setResignReason(ResignReasonInterface $resignReason = null): void;

    /**
     * @return string
     */
    public function getRemark(): ? string;

    /**
     * @param string $remark
     */
    public function setRemark(string $remark = null): void;
}
