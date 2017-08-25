<?php

namespace Persona\Hris\Allocation\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Persona\Hris\Allocation\Model\MutationInterface;
use Persona\Hris\Employee\Model\EmployeeInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class MutationSubscriber implements EventSubscriber
{
    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs): void
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof MutationInterface) {
            $employee = $entity->getEmployee();
            $this->apply($entity, $employee);
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs): void
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof MutationInterface) {
            $employee = $entity->getEmployee();
            $this->apply($entity, $employee);
        }
    }

    /**
     * @param MutationInterface $mutation
     * @param EmployeeInterface $employee
     */
    private function apply(MutationInterface $mutation, EmployeeInterface $employee): void
    {
        if ($mutation->getNewJobTitle()) {
            $employee->setJobTitle($mutation->getNewJobTitle());
        }

        if ($mutation->getNewJobClass()) {
            $employee->setJobClass($mutation->getNewJobClass());
        }

        if ($mutation->getNewCompany()) {
            $employee->setCompany($mutation->getNewCompany());
        }

        if ($mutation->getNewDepartment()) {
            $employee->setDepartment($mutation->getNewDepartment());
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
