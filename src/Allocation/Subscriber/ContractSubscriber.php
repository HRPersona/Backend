<?php

namespace Persona\Hris\Employee\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Persona\Hris\Employee\Model\ContractInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class ContractSubscriber implements EventSubscriber
{
    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs): void
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof ContractInterface) {
            $employee = $entity->getEmployee();
            $employee->setLetterNumber($entity->getLetterNumber());
            $employee->setContractEndDate($entity->getEndDate());
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs): void
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof ContractInterface) {
            $employee = $entity->getEmployee();
            $employee->setLetterNumber($entity->getLetterNumber());
            $employee->setContractEndDate($entity->getEndDate());
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
