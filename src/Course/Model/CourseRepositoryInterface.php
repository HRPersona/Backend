<?php

namespace Persona\Hris\Course\Model;

use Persona\Hris\Repository\RepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface CourseRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $id
     *
     * @return CourseInterface|null
     */
    public function find(string $id): ? CourseInterface;
}
