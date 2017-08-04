<?php

namespace Persona\Hris\Core\Security\Model;

use Persona\Hris\Repository\RepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface ModuleRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $path
     *
     * @return ModuleInterface|null
     */
    public function findByPath(string $path): ? ModuleInterface;
}
