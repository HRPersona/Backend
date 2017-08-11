<?php

namespace Persona\Hris\Share\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Persona\Hris\Share\Model\UniversityAwareInterface;
use Persona\Hris\Share\Model\UniversityInterface;
use Persona\Hris\Share\Model\UniversityRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class UniversityAwareSubscriber implements EventSubscriber
{
    /**
     * @var UniversityRepositoryInterface
     */
    private $repository;

    /**
     * @param UniversityRepositoryInterface $repository
     */
    public function __construct(UniversityRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof UniversityAwareInterface) {
            $this->isValidOrException($entity->getUniversityId());
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof UniversityAwareInterface) {
            $this->isValidOrException($entity->getUniversityId());
        }
    }

    /**
     * @param string $id
     *
     * @return bool|null
     */
    private function isValidOrException(string $id): ? bool
    {
        if (!$this->repository->find($id) instanceof UniversityInterface) {
            throw new NotFoundHttpException(sprintf('University with id %s is not found.', $id));
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
