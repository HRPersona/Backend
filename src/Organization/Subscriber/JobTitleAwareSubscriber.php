<?php

namespace Persona\Hris\Organization\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Persona\Hris\Organization\Model\JobTitleAwareInterface;
use Persona\Hris\Organization\Model\JobTitleInterface;
use Persona\Hris\Organization\Model\JobTitleRepositoryInterface;
use Persona\Hris\Organization\Model\NewJobTitleAwareInterface;
use Persona\Hris\Organization\Model\OldJobTitleAwareInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class JobTitleAwareSubscriber implements EventSubscriber
{
    /**
     * @var JobTitleRepositoryInterface
     */
    private $repository;

    /**
     * @param JobTitleRepositoryInterface $repository
     */
    public function __construct(JobTitleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof JobTitleAwareInterface) {
            $this->isValidOrException($entity->getJobTitleId());
        }

        if ($entity instanceof OldJobTitleAwareInterface) {
            $this->isValidOrException($entity->getOldJobTitleId());
        }

        if ($entity instanceof NewJobTitleAwareInterface) {
            $this->isValidOrException($entity->getNewJobTitleId());
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof JobTitleAwareInterface) {
            $this->isValidOrException($entity->getJobTitleId());
        }

        if ($entity instanceof OldJobTitleAwareInterface) {
            $this->isValidOrException($entity->getOldJobTitleId());
        }

        if ($entity instanceof NewJobTitleAwareInterface) {
            $this->isValidOrException($entity->getNewJobTitleId());
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function postLoad(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof NewJobTitleAwareInterface) {
            $this->repository->find($entity->getNewJobTitleId());
        }
    }

    /**
     * @param string $id
     *
     * @return bool|null
     */
    private function isValidOrException(string $id): ? bool
    {
        if (!$this->repository->find($id) instanceof JobTitleInterface) {
            throw new NotFoundHttpException(sprintf('Job title with id %s is not found.', $id));
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
