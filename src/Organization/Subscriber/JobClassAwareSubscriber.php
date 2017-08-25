<?php

namespace Persona\Hris\Organization\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Persona\Hris\Organization\Model\JobClassAwareInterface;
use Persona\Hris\Organization\Model\JobClassInterface;
use Persona\Hris\Organization\Model\JobClassRepositoryInterface;
use Persona\Hris\Organization\Model\NewJobClassAwareInterface;
use Persona\Hris\Organization\Model\OldJobClassAwareInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class JobClassAwareSubscriber implements EventSubscriber
{
    /**
     * @var JobClassRepositoryInterface
     */
    private $repository;

    /**
     * @param JobClassRepositoryInterface $repository
     */
    public function __construct(JobClassRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof JobClassAwareInterface) {
            $this->isValidOrException($entity->getJobClassId());
        }

        if ($entity instanceof OldJobClassAwareInterface) {
            $this->isValidOrException($entity->getOldJobClassId());
        }

        if ($entity instanceof NewJobClassAwareInterface) {
            $this->isValidOrException($entity->getNewJobClassId());
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof JobClassAwareInterface) {
            $this->isValidOrException($entity->getJobClassId());
        }

        if ($entity instanceof OldJobClassAwareInterface) {
            $this->isValidOrException($entity->getOldJobClassId());
        }

        if ($entity instanceof NewJobClassAwareInterface) {
            $this->isValidOrException($entity->getNewJobClassId());
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function postLoad(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof NewJobClassAwareInterface) {
            $this->repository->find($entity->getNewJobClassId());
        }
    }

    /**
     * @param string $id
     *
     * @return bool|null
     */
    private function isValidOrException(string $id): ? bool
    {
        if (!$this->repository->find($id) instanceof JobClassInterface) {
            throw new NotFoundHttpException(sprintf('Job class with id %s is not found.', $id));
        }

        return true;
    }

    /**
     * @return array
     */
    public function getSubscribedEvents(): array
    {
        return [Events::prePersist, Events::preUpdate, Events::postLoad];
    }
}
