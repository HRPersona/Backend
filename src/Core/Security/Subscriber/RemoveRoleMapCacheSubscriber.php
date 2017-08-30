<?php

namespace Persona\Hris\Core\Security\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Core\Security\Model\RoleHierarchyRepositoryInterface;
use Persona\Hris\Core\Security\Model\RoleInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class RemoveRoleMapCacheSubscriber implements EventSubscriber
{
    /**
     * @var ManagerFactory
     */
    private $managerFactory;

    /**
     * @param ManagerFactory $managerFactory
     */
    public function __construct(ManagerFactory $managerFactory)
    {
        $this->managerFactory = $managerFactory;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        if ($eventArgs->getEntity() instanceof RoleInterface) {
            $this->deleteRoleCache();
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        if ($eventArgs->getEntity() instanceof RoleInterface) {
            $this->deleteRoleCache();
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preRemove(LifecycleEventArgs $eventArgs)
    {
        if ($eventArgs->getEntity() instanceof RoleInterface) {
            $this->deleteRoleCache();
        }
    }

    private function deleteRoleCache()
    {
        $this->managerFactory->getCacheDriver()->delete(RoleHierarchyRepositoryInterface::CACHEID);
    }

    /**
     * @return array
     */
    public function getSubscribedEvents(): array
    {
        return [Events::preRemove, Events::prePersist, Events::preUpdate];
    }
}
