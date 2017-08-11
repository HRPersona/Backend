<?php

namespace Persona\Hris\Attendance\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Persona\Hris\Attendance\Model\AbsentReasonAwareInterface;
use Persona\Hris\Attendance\Model\AbsentReasonInterface;
use Persona\Hris\Attendance\Model\AbsentReasonRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class AbsentReasonAwareSubscriber implements EventSubscriber
{
    /**
     * @var AbsentReasonRepositoryInterface
     */
    private $repository;

    /**
     * @param AbsentReasonRepositoryInterface $repository
     */
    public function __construct(AbsentReasonRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof AbsentReasonAwareInterface) {
            $this->isValidOrException($entity->getAbsentReasonId());
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof AbsentReasonAwareInterface) {
            $this->isValidOrException($entity->getAbsentReasonId());
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function postLoad(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof AbsentReasonAwareInterface) {
            $entity->setAbsentReason($this->repository->find($entity->getAbsentReasonId()));
        }
    }

    /**
     * @param string $id
     *
     * @return bool|null
     */
    private function isValidOrException(string $id): ? bool
    {
        if (!$this->repository->find($id) instanceof AbsentReasonInterface) {
            throw new NotFoundHttpException(sprintf('Absent reason with id %s is not found.', $id));
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
