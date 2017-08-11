<?php

namespace Persona\Hris\Organization\Model;

use Persona\Hris\Repository\RepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface DepartmentRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $id
     *
     * @return DepartmentInterface|null
     */
    public function find(string $id): ? DepartmentInterface;
}
