<?php

namespace Persona\Hris\Share\Model;

use Persona\Hris\Repository\RepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface ProvinceRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $id
     *
     * @return ProvinceInterface|null
     */
    public function find(string $id): ? ProvinceInterface;
}
