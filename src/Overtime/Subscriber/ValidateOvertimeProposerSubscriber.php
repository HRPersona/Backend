<?php

namespace Persona\Hris\Overtime\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Persona\Hris\Overtime\Model\EmployeeOvertimeInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class ValidateOvertimeProposerSubscriber implements EventSubscriber
{
    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof EmployeeOvertimeInterface) {
            if ($entity->getProposedBy() && $entity->getProposedBy() !== $entity->getEmployee()->getSupervisor()) {
                throw new BadRequestHttpException('Proposer is not valid.');
            }
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof EmployeeOvertimeInterface) {
            if ($entity->getProposedBy() && $entity->getProposedBy() !== $entity->getEmployee()->getSupervisor()) {
                throw new BadRequestHttpException('Proposer is not valid.');
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
