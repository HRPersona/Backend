<?php

namespace Persona\Hris\Share\Model;

use Persona\Hris\Repository\RepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface EducationTitleRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $id
     *
     * @return EducationTitleInterface|null
     */
    public function find(string $id): ? EducationTitleInterface;
}
