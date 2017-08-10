<?php

namespace Persona\Hris\Attendance\Model;

use Persona\Hris\Repository\RepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface ShiftmentRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $id
     *
     * @return ShiftmentInterface|null
     */
    public function find(string $id): ? ShiftmentInterface;
}
