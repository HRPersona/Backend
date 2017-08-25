<?php

namespace Persona\Hris\Performance\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Persona\Hris\Performance\Model\SupervisorAwareInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class ValidateSupervisorSubscriber implements EventSubscriber
{
    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof SupervisorAwareInterface) {
            $this->validateSupervisor($entity);
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof SupervisorAwareInterface) {
            $this->validateSupervisor($entity);
        }
    }

    /**
     * @param SupervisorAwareInterface $supervisorAware
     */
    private function validateSupervisor(SupervisorAwareInterface $supervisorAware)
    {
        if ($supervisorAware->getFirstSupervisorAppraisalBy() && null === $supervisorAware->getSecondSupervisorAppraisalBy()) {
            if ($supervisorAware->getFirstSupervisorAppraisalBy() !== $supervisorAware->getEmployee()->getSupervisor()) {
                throw new BadRequestHttpException('First supervisor is not valid.');
            }
        }

        if ($supervisorAware->getSecondSupervisorAppraisalBy()) {
            if (null === $supervisorAware->getFirstSupervisorAppraisalBy()) {
                throw new BadRequestHttpException('First supervisor must set before.');
            }

            if ($supervisorAware->getSecondSupervisorAppraisalBy() !== $supervisorAware->getFirstSupervisorAppraisalBy()->getSupervisor()) {
                throw new BadRequestHttpException('First supervisor is not valid.');
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
