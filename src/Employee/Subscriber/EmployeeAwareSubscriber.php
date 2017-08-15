<?php

namespace Persona\Hris\Employee\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Persona\Hris\Employee\Model\ApprovedByAwareInterface;
use Persona\Hris\Employee\Model\EmployeeAwareInterface;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Employee\Model\EmployeeRepositoryInterface;
use Persona\Hris\Employee\Model\ProposedByAwareInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class EmployeeAwareSubscriber implements EventSubscriber
{
    /**
     * @var EmployeeRepositoryInterface
     */
    private $repository;

    /**
     * @param EmployeeRepositoryInterface $repository
     */
    public function __construct(EmployeeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof EmployeeAwareInterface) {
            $this->isValidOrException($entity->getEmployeeId());
        }

        if ($entity instanceof ApprovedByAwareInterface) {
            $this->isValidOrException($entity->getApprovedById());
        }

        if ($entity instanceof ProposedByAwareInterface) {
            $this->isValidOrException($entity->getProposedById());
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof EmployeeAwareInterface) {
            $this->isValidOrException($entity->getEmployeeId());
        }

        if ($entity instanceof ApprovedByAwareInterface) {
            $this->isValidOrException($entity->getApprovedById());
        }

        if ($entity instanceof ProposedByAwareInterface) {
            $this->isValidOrException($entity->getProposedById());
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function postLoad(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof EmployeeAwareInterface) {
            $entity->setEmployee($this->repository->find($entity->getEmployeeId()));
        }
    }

    /**
     * @param string $id
     *
     * @return bool|null
     */
    private function isValidOrException(string $id): ? bool
    {
        if (!$this->repository->find($id) instanceof EmployeeInterface) {
            throw new NotFoundHttpException(sprintf('Employee with id %s is not found.', $id));
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
