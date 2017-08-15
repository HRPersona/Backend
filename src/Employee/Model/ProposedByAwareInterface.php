<?php

namespace Persona\Hris\Employee\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface ProposedByAwareInterface
{
    /**
     * @return string
     */
    public function getProposedById(): string;

    /**
     * @param string|null $employee
     */
    public function setProposedById(string $employee = null);

    /**
     * @return null|EmployeeInterface
     */
    public function getProposedBy(): ? EmployeeInterface;

    /**
     * @param EmployeeInterface|null $employee
     */
    public function setProposedBy(EmployeeInterface $employee = null): void;
}
