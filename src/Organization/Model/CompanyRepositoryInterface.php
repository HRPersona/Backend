<?php

namespace Persona\Hris\Organization\Model;

use Persona\Hris\Repository\RepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface CompanyRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $id
     *
     * @return CompanyInterface|null
     */
    public function find(string $id): ? CompanyInterface;
}
