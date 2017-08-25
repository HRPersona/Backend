<?php

namespace Persona\Hris\Allocation\Model;

use Persona\Hris\Repository\RepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface ResignReasonRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $id
     *
     * @return ResignReasonInterface|null
     */
    public function find(string $id): ? ResignReasonInterface;
}
