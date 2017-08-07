<?php

namespace Persona\Hris\Core\Security\Model;

use Persona\Hris\Repository\RepositoryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface RoleHierarchyRepositoryInterface extends RepositoryInterface
{
    const CACHEID = 'HRPERSONA_ROLE_HIERARCHY';

    /**
     * @return array
     */
    public function mapRoles(): array;

    /**
     * @param Request         $request
     * @param ModuleInterface $module
     *
     * @return bool
     */
    public function isGranted(Request $request, ModuleInterface $module): bool;
}
