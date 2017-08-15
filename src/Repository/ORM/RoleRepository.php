<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Core\Security\Model\ModuleInterface;
use Persona\Hris\Core\Security\Model\RoleInterface;
use Persona\Hris\Core\Security\Model\RoleRepositoryInterface;
use Persona\Hris\Core\Security\Model\UserInterface;
use Persona\Hris\Repository\AbstractRepository;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class RoleRepository extends AbstractRepository implements RoleRepositoryInterface
{
    /**
     * @param ManagerFactory $managerFactory
     * @param string         $class
     */
    public function __construct(ManagerFactory $managerFactory, string $class)
    {
        parent::__construct($managerFactory, $class);
    }

    /**
     * @param UserInterface   $user
     * @param ModuleInterface $module
     *
     * @return RoleInterface|null
     */
    public function findByUserAndModule(UserInterface $user, ModuleInterface $module): ? RoleInterface
    {
        return $this->managerFactory->getReadManager()->getRepository($this->class)->findOneBy(['moduleId' => $module->getId(), 'userId' => $user->getId(), 'deletedAt' => null]);
    }

    /**
     * @param ModuleInterface $module
     *
     * @return array|null
     */
    public function findByModule(ModuleInterface $module): ? array
    {
        return $this->managerFactory->getWriteManager()->getRepository($this->class)->findBy(['moduleId' => $module->getId(), 'deletedAt' => null]);
    }

    /**
     * @param ModuleInterface $module
     */
    public function removeByModule(ModuleInterface $module): void
    {
        $roles = $this->findByModule($module);
        $manager = $this->managerFactory->getWriteManager();
        foreach ($roles as $key => $role) {
            $manager->remove($role);

            if (0 === $key % 17) {
                $manager->flush();
            }
        }

        $manager->flush();
    }

    /**
     * @param UserInterface $user
     *
     * @return array|null
     */
    public function findByUser(UserInterface $user): ? array
    {
        return $this->managerFactory->getReadManager()->getRepository($this->class)->findBy(['userId' => $user->getId(), 'deletedAt' => null]);
    }
}
