<?php

namespace Persona\Hris\Core\Security\Model;

use Persona\Hris\Repository\CachableRepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface RoleRepositoryInterface extends CachableRepositoryInterface
{
    /**
     * @param UserInterface   $user
     * @param ModuleInterface $module
     *
     * @return RoleInterface|null
     */
    public function findByUserAndModule(UserInterface $user, ModuleInterface $module): ? RoleInterface;

    /**
     * @param ModuleInterface $module
     *
     * @return array|null
     */
    public function findByModule(ModuleInterface $module): ? array;
}
