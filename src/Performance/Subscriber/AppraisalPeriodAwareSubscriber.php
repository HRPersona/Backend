<?php

namespace Persona\Hris\Performance\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Persona\Hris\Performance\Model\AppraisalPeriodAwareInterface;
use Persona\Hris\Performance\Model\AppraisalPeriodInterface;
use Persona\Hris\Performance\Model\AppraisalPeriodRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class AppraisalPeriodAwareSubscriber implements EventSubscriber
{
    /**
     * @var AppraisalPeriodRepositoryInterface
     */
    private $repository;

    /**
     * @param AppraisalPeriodRepositoryInterface $repository
     */
    public function __construct(AppraisalPeriodRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof AppraisalPeriodAwareInterface) {
            $this->isValidOrException($entity->getAppraisalPeriodId());
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof AppraisalPeriodAwareInterface) {
            $this->isValidOrException($entity->getAppraisalPeriodId());
        }
    }

    /**
     * @param string $id
     *
     * @return bool|null
     */
    private function isValidOrException(string $id): ? bool
    {
        if (!$this->repository->find($id) instanceof AppraisalPeriodInterface) {
            throw new NotFoundHttpException(sprintf('AppraisalPeriod with id %s is not found.', $id));
        }

        return true;
    }

    /**
     * @return array
     */
    public function getSubscribedEvents(): array
    {
        return [Events::prePersist, Events::preUpdate];
    }
}
