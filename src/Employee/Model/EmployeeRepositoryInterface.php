<?php

namespace Persona\Hris\Employee\Model;

use Persona\Hris\Repository\CachableRepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface EmployeeRepositoryInterface extends CachableRepositoryInterface
{
    /**
     * @return array
     */
    public function findActiveEmployee(): array;

    /**
     * @param string $id
     *
     * @return null|EmployeeInterface
     */
    public function find(string $id): ? EmployeeInterface;
}
