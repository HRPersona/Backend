<?php

namespace Persona\Hris\Core\Security\Model;

use Persona\Hris\Repository\CachableRepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface ModuleRepositoryInterface extends CachableRepositoryInterface
{
    /**
     * @param string $path
     *
     * @return ModuleInterface|null
     */
    public function findByPath(string $path): ? ModuleInterface;
}
