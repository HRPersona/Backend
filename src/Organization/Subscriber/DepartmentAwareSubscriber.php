<?php

namespace Persona\Hris\Organization\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Persona\Hris\Organization\Model\DepartmentAwareInterface;
use Persona\Hris\Organization\Model\DepartmentInterface;
use Persona\Hris\Organization\Model\DepartmentRepositoryInterface;
use Persona\Hris\Organization\Model\NewDepartmentAwareInterface;
use Persona\Hris\Organization\Model\OldDepartmentAwareInterface;
use Persona\Hris\Organization\Model\ParentDepartmentAwareInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class DepartmentAwareSubscriber implements EventSubscriber
{
    /**
     * @var DepartmentRepositoryInterface
     */
    private $repository;

    /**
     * @param DepartmentRepositoryInterface $repository
     */
    public function __construct(DepartmentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof DepartmentAwareInterface) {
            $this->isValidOrException($entity->getDepartmentId());
        }

        if ($entity instanceof ParentDepartmentAwareInterface) {
            $this->isValidOrException($entity->getParentId());
        }

        if ($entity instanceof OldDepartmentAwareInterface) {
            $this->isValidOrException($entity->getOldDepartmentId());
        }

        if ($entity instanceof NewDepartmentAwareInterface) {
            $this->isValidOrException($entity->getNewDepartmentId());
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof DepartmentAwareInterface) {
            $this->isValidOrException($entity->getDepartmentId());
        }

        if ($entity instanceof ParentDepartmentAwareInterface) {
            $this->isValidOrException($entity->getParentId());
        }

        if ($entity instanceof OldDepartmentAwareInterface) {
            $this->isValidOrException($entity->getOldDepartmentId());
        }

        if ($entity instanceof NewDepartmentAwareInterface) {
            $this->isValidOrException($entity->getNewDepartmentId());
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function postLoad(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof NewDepartmentAwareInterface) {
            $this->repository->find($entity->getNewDepartmentId());
        }
    }

    /**
     * @param string $id
     *
     * @return bool|null
     */
    private function isValidOrException(string $id): ? bool
    {
        if (!$this->repository->find($id) instanceof DepartmentInterface) {
            throw new NotFoundHttpException(sprintf('Department with id %s is not found.', $id));
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
