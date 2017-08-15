<?php

namespace Persona\Hris\Leave\Model;

use Persona\Hris\Repository\RepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface LeaveRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $id
     *
     * @return LeaveInterface|null
     */
    public function find(string $id): ? LeaveInterface;
}
