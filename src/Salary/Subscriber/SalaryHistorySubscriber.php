<?php

namespace Persona\Hris\Salary\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Persona\Hris\Salary\Model\SalaryHistoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class SalaryHistorySubscriber implements EventSubscriber
{
    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs): void
    {
        $salaryHistory = $eventArgs->getEntity();
        if ($salaryHistory instanceof SalaryHistoryInterface) {
            $employee = $salaryHistory->getEmployee();
            $employee->setBasicSalary($salaryHistory->getBasicSalary());

            $manager = $eventArgs->getEntityManager();
            $manager->persist($employee);
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs): void
    {
        $salaryHistory = $eventArgs->getEntity();
        if ($salaryHistory instanceof SalaryHistoryInterface) {
            $employee = $salaryHistory->getEmployee();
            $employee->setBasicSalary($salaryHistory->getBasicSalary());

            $manager = $eventArgs->getEntityManager();
            $manager->persist($employee);
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
