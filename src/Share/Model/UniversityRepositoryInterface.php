<?php

namespace Persona\Hris\Share\Model;

use Persona\Hris\Repository\RepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface UniversityRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $id
     *
     * @return UniversityInterface|null
     */
    public function find(string $id): ? UniversityInterface;
}
