<?php

namespace Persona\Hris\Employee\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface ContractInterface
{
    const TYPE_PERMANENT = 'p';
    const TYPE_CONTRACT = 'c';
    const TYPE_OUTSOURCE = 'o';
     const TYPE_INTERSHIP = 'i';

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
    public function getStartDate(): \DateTime;

    /**
     * @return \DateTime
     */
    public function getEndDate(): \DateTime;

    /**
     * @return string
     */
    public function getLetterNumber(): string;

    /**
     * @return string
     */
    public function getContractType(): string;
}
