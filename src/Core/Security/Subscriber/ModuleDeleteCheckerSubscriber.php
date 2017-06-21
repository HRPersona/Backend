<?php

namespace Persona\Hris\Core\Security\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Persona\Hris\Core\Security\Model\ModuleInterface;
use Persona\Hris\Core\Security\Model\RoleRepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class ModuleDeleteCheckerSubscriber implements EventSubscriber
{
    /**
     * @var RoleRepositoryInterface
     */
    private $roleRepository;

    /**
     * @param RoleRepositoryInterface $repository
     */
    public function __construct(RoleRepositoryInterface $repository)
    {
        $this->roleRepository = $repository;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preRemove(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if (!$entity instanceof ModuleInterface) {
            return;
        }

        $roles = $this->roleRepository->findByModule($entity);
        $manager = $eventArgs->getEntityManager();
        foreach ($roles as $role) {
            $manager->remove($role);
        }
        $manager->flush();
    }

    /**
     * @return array
     */
    public function getSubscribedEvents(): array
    {
        return [Events::preRemove];
    }
}
