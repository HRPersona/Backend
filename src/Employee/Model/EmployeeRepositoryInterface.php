<?php

namespace Persona\Hris\Employee\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface EmployeeRepositoryInterface
{
    /**
     * @return array
     */
    public function findActiveEmployee(): array;
}
