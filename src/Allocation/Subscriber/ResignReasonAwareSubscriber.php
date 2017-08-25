<?php

namespace Persona\Hris\Allocation\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Persona\Hris\Allocation\Model\ResignReasonAwareInterface;
use Persona\Hris\Allocation\Model\ResignReasonInterface;
use Persona\Hris\Allocation\Model\ResignReasonRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class ResignReasonAwareSubscriber implements EventSubscriber
{
    /**
     * @var ResignReasonRepositoryInterface
     */
    private $repository;

    /**
     * @param ResignReasonRepositoryInterface $repository
     */
    public function __construct(ResignReasonRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof ResignReasonAwareInterface) {
            $this->isValidOrException($entity->getResignReasonId());
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof ResignReasonAwareInterface) {
            $this->isValidOrException($entity->getResignReasonId());
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function postLoad(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof ResignReasonAwareInterface) {
            $entity->setResignReason($this->repository->find($entity->getResignReasonId()));
        }
    }

    /**
     * @param string $id
     *
     * @return bool|null
     */
    private function isValidOrException(string $id): ? bool
    {
        if (!$this->repository->find($id) instanceof ResignReasonInterface) {
            throw new NotFoundHttpException(sprintf('Resign reason with id %s is not found.', $id));
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
