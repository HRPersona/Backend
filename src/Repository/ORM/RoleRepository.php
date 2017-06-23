<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Core\Security\Model\ModuleInterface;
use Persona\Hris\Core\Security\Model\RoleInterface;
use Persona\Hris\Core\Security\Model\RoleRepositoryInterface;
use Persona\Hris\Core\Security\Model\UserInterface;
use Persona\Hris\Repository\AbstractCachableRepository;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class RoleRepository extends AbstractCachableRepository implements RoleRepositoryInterface
{
    /**
     * @var string
     */
    private $class;

    /**
     * @param ManagerFactory $managerFactory
     * @param string         $class
     */
    public function __construct(ManagerFactory $managerFactory, string $class)
    {
        parent::__construct($managerFactory);
        $this->class = $class;
    }

    /**
     * @param UserInterface   $user
     * @param ModuleInterface $module
     *
     * @return RoleInterface|null
     */
    public function findByUserAndModule(UserInterface $user, ModuleInterface $module): ? RoleInterface
    {
        $cache = $this->getCacheDriver();
        $cacheId = sprintf('%s_%s_%s', $this->class, $user->getId(), $module->getId());
        if ($cache->contains($cacheId)) {
            $data = $cache->fetch($cacheId);
            $this->managerFactory->merge([$data]);
        } else {
            /** @var RoleInterface $data */
            $data = $this->managerFactory->getReadManager()->getRepository($this->class)->findOneBy(['module' => $module, 'user' => $user, 'deletedAt' => null]);
            $cache->save($cacheId, $data, $this->getCacheLifetime());
        }

        return $data;
    }

    /**
     * @param ModuleInterface $module
     *
     * @return array|null
     */
    public function findByModule(ModuleInterface $module): ? array
    {
        $cache = $this->getCacheDriver();
        $cacheId = sprintf('%s_%s', $this->class, $module->getId());
        if ($cache->contains($cacheId)) {
            $data = $cache->fetch($cacheId);
            $this->managerFactory->merge([$data]);
        } else {
            /** @var RoleInterface $data */
            $data = $this->managerFactory->getWriteManager()->getRepository($this->class)->findBy(['module' => $module, 'deletedAt' => null]);
            $cache->save($cacheId, $data, $this->getCacheLifetime());
        }

        return $data;
    }
}
