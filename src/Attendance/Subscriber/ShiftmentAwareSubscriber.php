<?php

namespace Persona\Hris\Attendance\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Persona\Hris\Attendance\Model\ShiftmentAwareInterface;
use Persona\Hris\Attendance\Model\ShiftmentInterface;
use Persona\Hris\Attendance\Model\ShiftmentRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class ShiftmentAwareSubscriber implements EventSubscriber
{
    /**
     * @var ShiftmentRepositoryInterface
     */
    private $repository;

    /**
     * @param ShiftmentRepositoryInterface $repository
     */
    public function __construct(ShiftmentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof ShiftmentAwareInterface) {
            $this->isValidOrException($entity->getModuleId());
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof ShiftmentAwareInterface) {
            $this->isValidOrException($entity->getModuleId());
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function postLoad(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof ShiftmentAwareInterface) {
            $entity->setModule($this->repository->find($entity->getModuleId()));
        }
    }

    /**
     * @param string $id
     *
     * @return bool|null
     */
    private function isValidOrException(string $id): ? bool
    {
        if (!$this->repository->find($id) instanceof ShiftmentInterface) {
            throw new NotFoundHttpException(sprintf('Shiftment with id %s is not found.', $id));
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
