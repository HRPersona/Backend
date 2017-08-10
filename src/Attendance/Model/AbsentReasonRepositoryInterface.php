<?php

namespace Persona\Hris\Attendance\Model;

use Persona\Hris\Repository\RepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface AbsentReasonRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $id
     *
     * @return AbsentReasonInterface|null
     */
    public function find(string $id): ? AbsentReasonInterface;
}
