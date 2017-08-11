<?php

namespace Persona\Hris\Performance\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Persona\Hris\Performance\Model\IndicatorAwareInterface;
use Persona\Hris\Performance\Model\IndicatorInterface;
use Persona\Hris\Performance\Model\IndicatorRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class IndicatorAwareSubscriber implements EventSubscriber
{
    /**
     * @var IndicatorRepositoryInterface
     */
    private $repository;

    /**
     * @param IndicatorRepositoryInterface $repository
     */
    public function __construct(IndicatorRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof IndicatorAwareInterface) {
            $this->isValidOrException($entity->getIndicatorId());
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof IndicatorAwareInterface) {
            $this->isValidOrException($entity->getIndicatorId());
        }
    }

    /**
     * @param string $id
     *
     * @return bool|null
     */
    private function isValidOrException(string $id): ? bool
    {
        if (!$this->repository->find($id) instanceof IndicatorInterface) {
            throw new NotFoundHttpException(sprintf('Indicator with id %s is not found.', $id));
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
