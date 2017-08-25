<?php

namespace Persona\Hris\Organization\Model;

use Persona\Hris\Repository\RepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface JobClassRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $id
     *
     * @return JobClassInterface|null
     */
    public function find(string $id): ? JobClassInterface;
}
