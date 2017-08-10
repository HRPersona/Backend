<?php

namespace Persona\Hris\Core\Security\Model;

use Persona\Hris\Repository\RepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface ServiceRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $id
     *
     * @return ServiceInterface|null
     */
    public function find(string $id): ? ServiceInterface;
}
