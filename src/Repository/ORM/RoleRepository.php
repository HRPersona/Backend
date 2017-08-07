<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Core\Security\Model\ModuleInterface;
use Persona\Hris\Core\Security\Model\RoleInterface;
use Persona\Hris\Core\Security\Model\RoleRepositoryInterface;
use Persona\Hris\Core\Security\Model\UserInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class RoleRepository implements RoleRepositoryInterface
{
    /**
     * @var string
     */
    private $class;

    /**
     * @var ManagerFactory
     */
    private $managerFactory;

    /**
     * @param ManagerFactory $managerFactory
     * @param string         $class
     */
    public function __construct(ManagerFactory $managerFactory, string $class)
    {
        $this->managerFactory = $managerFactory;
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
        return $this->managerFactory->getReadManager()->getRepository($this->class)->findOneBy(['module' => $module, 'user' => $user, 'deletedAt' => null]);
    }

    /**
     * @param ModuleInterface $module
     *
     * @return array|null
     */
    public function findByModule(ModuleInterface $module): ? array
    {
        return $this->managerFactory->getWriteManager()->getRepository($this->class)->findBy(['module' => $module, 'deletedAt' => null]);
    }

    /**
     * @param UserInterface $user
     *
     * @return array|null
     */
    public function findByUser(UserInterface $user): ? array
    {
        return $this->managerFactory->getReadManager()->getRepository($this->class)->findBy(['user' => $user, 'deletedAt' => null]);
    }
}
