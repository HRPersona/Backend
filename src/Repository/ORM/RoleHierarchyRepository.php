<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Core\Security\Model\ModuleInterface;
use Persona\Hris\Core\Security\Model\RoleHierarchyRepositoryInterface;
use Persona\Hris\Core\Security\Model\RoleInterface;
use Persona\Hris\Core\Security\Model\RoleRepositoryInterface;
use Persona\Hris\Core\Security\Model\UserInterface;
use Persona\Hris\Core\Util\StringUtil;
use Persona\Hris\Repository\AbstractRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class RoleHierarchyRepository extends AbstractRepository implements RoleHierarchyRepositoryInterface
{
    const VIEW = 'GET';
    const WRITE = 'POST';
    const UPDATE = 'PUT';
    const DELETE = 'DELETE';

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var string
     */
    private $class;

    /**
     * @var RoleRepositoryInterface
     */
    private $roleRepository;

    /**
     * @param RoleRepositoryInterface $roleRepository
     * @param TokenStorageInterface   $tokenStorage
     * @param ManagerFactory          $managerFactory
     * @param string                  $class
     */
    public function __construct(
        RoleRepositoryInterface $roleRepository,
        TokenStorageInterface $tokenStorage,
        ManagerFactory $managerFactory,
        string  $class
    ) {
        parent::__construct($managerFactory);
        $this->roleRepository = $roleRepository;
        $this->tokenStorage = $tokenStorage;
        $this->class = $class;
    }

    /**
     * @return array
     */
    public function mapRoles(): array
    {
        $cacheDriver = $this->managerFactory->getCacheDriver();
        if ($cacheDriver->contains(self::CACHEID)) {
            return $cacheDriver->fetch(self::CACHEID);
        }

        $roles = [];
        $data = $this->managerFactory->getReadManager()->getRepository($this->class)->findBy(['deletedAt' => null]);
        foreach ($data as $user) {
            if (!$user instanceof UserInterface) {
                break;
            }

            $userRole = $user->getRoles();
            if (!key_exists(sprintf('ROLE_%s', $userRole[0]), $roles)) {
                $roles[sprintf('ROLE_%s', $userRole[0])] = [];
            }

            $r = $this->roleRepository->findByUser($user);
            /** @var RoleInterface $item */
            foreach ($r as $item) {
                if ($item->getAddable()) {
                    $roles[sprintf('ROLE_%s', $userRole[0])][] = sprintf('ROLE_%s_ADD', StringUtil::underscore($item->getModule()->getName()));
                }

                if ($item->getEditable()) {
                    $roles[sprintf('ROLE_%s', $userRole[0])][] = sprintf('ROLE_%s_EDIT', StringUtil::underscore($item->getModule()->getName()));
                }

                if ($item->getDeletable()) {
                    $roles[sprintf('ROLE_%s', $userRole[0])][] = sprintf('ROLE_%s_DELETE', StringUtil::underscore($item->getModule()->getName()));
                }

                if ($item->getViewable()) {
                    $roles[sprintf('ROLE_%s', $userRole[0])][] = sprintf('ROLE_%s_VIEW', StringUtil::underscore($item->getModule()->getName()));
                }
            }
        }

        $cacheDriver->save(self::CACHEID, $roles);

        return $roles;
    }

    /**
     * @param Request         $request
     * @param ModuleInterface $module
     *
     * @return bool
     */
    public function isGranted(Request $request, ModuleInterface $module): bool
    {
        if (!$this->tokenStorage->getToken()) {
            return false;
        }

        if (!$role = $this->roleRepository->findByUserAndModule($this->tokenStorage->getToken()->getUser(), $module)) {
            return false;
        }

        switch (strtoupper($request->getMethod())) {
            case self::VIEW:
                return $role->getViewable();
                break;
            case self::WRITE:
                return $role->getAddable();
                break;
            case self::UPDATE:
                return $role->getEditable();
                break;
            case self::DELETE:
                return $role->getDeletable();
                break;
            default:
                return false;
                break;
        }
    }
}
