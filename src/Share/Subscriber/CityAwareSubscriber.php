<?php

namespace Persona\Hris\Share\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Persona\Hris\Share\Model\CityAwareInterface;
use Persona\Hris\Share\Model\CityInterface;
use Persona\Hris\Share\Model\CityRepositoryInterface;
use Persona\Hris\Share\Model\PlaceOfBirthAwareInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class CityAwareSubscriber implements EventSubscriber
{
    /**
     * @var CityRepositoryInterface
     */
    private $repository;

    /**
     * @param CityRepositoryInterface $repository
     */
    public function __construct(CityRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof CityAwareInterface) {
            $this->isValidOrException($entity->getCityId());
        }

        if ($entity instanceof PlaceOfBirthAwareInterface) {
            $this->isValidOrException($entity->getPlaceOfBirthId());
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof PlaceOfBirthAwareInterface) {
            $this->isValidOrException($entity->getCityId());
        }

        if ($entity instanceof PlaceOfBirthAwareInterface) {
            $this->isValidOrException($entity->getPlaceOfBirthId());
        }
    }

    /**
     * @param string $id
     *
     * @return bool|null
     */
    private function isValidOrException(string $id): ? bool
    {
        if (!$this->repository->find($id) instanceof CityInterface) {
            throw new NotFoundHttpException(sprintf('City with id %s is not found.', $id));
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
