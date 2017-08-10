<?php

namespace Persona\Hris\Core\Security\Model;

use Persona\Hris\Repository\RepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface ModuleRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $id
     *
     * @return null|ModuleInterface
     */
    public function find(string $id): ? ModuleInterface;

    /**
     * @param string $path
     *
     * @return ModuleInterface|null
     */
    public function findByPath(string $path): ? ModuleInterface;
}
