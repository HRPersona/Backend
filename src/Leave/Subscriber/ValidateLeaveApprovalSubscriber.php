<?php

namespace Persona\Hris\Leave\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Persona\Hris\Leave\Model\EmployeeLeaveInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class ValidateLeaveApprovalSubscriber implements EventSubscriber
{
    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof EmployeeLeaveInterface) {
            if ($entity->getApprovedBy() && $entity->getApprovedBy() !== $entity->getEmployee()->getSupervisor()) {
                throw new BadRequestHttpException('Approver is not valid.');
            }
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof EmployeeLeaveInterface) {
            if ($entity->getApprovedBy() && $entity->getApprovedBy() !== $entity->getEmployee()->getSupervisor()) {
                throw new BadRequestHttpException('Approver is not valid.');
            }
        }
    }

    /**
     * @return array
     */
    public function getSubscribedEvents(): array
    {
        return [Events::prePersist, Events::preUpdate];
    }
}
