<?php

namespace Persona\Hris\Share\Model;

use Persona\Hris\Repository\RepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface CityRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $id
     *
     * @return CityInterface|null
     */
    public function find(string $id): ? CityInterface;
}
