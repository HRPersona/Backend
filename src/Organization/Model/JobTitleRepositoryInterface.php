<?php

namespace Persona\Hris\Organization\Model;

use Persona\Hris\Repository\RepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface JobTitleRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $id
     *
     * @return JobTitleInterface|null
     */
    public function find(string $id): ? JobTitleInterface;
}
