<?php

namespace Persona\Hris\Core\Security\Authorization;

use Persona\Hris\Core\Security\Model\RoleHierarchyRepositoryInterface;
use Symfony\Component\Security\Core\Role\RoleHierarchy as Base;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
class RoleHierarchy implements RoleHierarchyInterface
{
    /**
     * @var RoleHierarchyRepositoryInterface
     */
    private $roleHierarchyRepository;

    /**
     * @var array
     */
    private $roleHierarchy;

    /**
     * @param RoleHierarchyRepositoryInterface $roleHierarchyRepository
     */
    public function __construct(RoleHierarchyRepositoryInterface $roleHierarchyRepository)
    {
        $this->roleHierarchyRepository = $roleHierarchyRepository;
    }

    /**
     * @param \Symfony\Component\Security\Core\Role\Role[] $roles An array of directly assigned roles
     *
     * @return \Symfony\Component\Security\Core\Role\Role[] An array of all reachable roles
     */
    public function getReachableRoles(array $roles)
    {
        if (null === $this->roleHierarchy) {
            $this->roleHierarchy = new Base($this->roleHierarchyRepository->mapRoles());
        }

        return $this->roleHierarchy->getReachableRoles($roles);
    }
}
