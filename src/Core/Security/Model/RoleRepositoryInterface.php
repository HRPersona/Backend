<?php

namespace Persona\Hris\Core\Security\Model;

use Persona\Hris\Repository\RepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface RoleRepositoryInterface extends RepositoryInterface
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

    /**
     * @param ModuleInterface $module
     */
    public function removeByModule(ModuleInterface $module): void;

    /**
     * @param UserInterface $user
     *
     * @return array|null
     */
    public function findByUser(UserInterface $user): ? array;
}
