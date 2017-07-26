<?php

namespace Persona\Hris\Employee\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
class EmployeeCourseSubscriber implements EventSubscriber
{
    public function __construct()
    {
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
    }

    /**
     * @return array
     */
    public function getSubscribedEvents(): array
    {
        return [Events::prePersist];
    }
}
