<?php

namespace Persona\Hris\Share\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Persona\Hris\Share\Model\ProvinceAwareInterface;
use Persona\Hris\Share\Model\ProvinceInterface;
use Persona\Hris\Share\Model\ProvinceRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class ProvinceAwareSubscriber implements EventSubscriber
{
    /**
     * @var ProvinceRepositoryInterface
     */
    private $repository;

    /**
     * @param ProvinceRepositoryInterface $repository
     */
    public function __construct(ProvinceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof ProvinceAwareInterface) {
            $this->isValidOrException($entity->getModuleId());
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof ProvinceAwareInterface) {
            $this->isValidOrException($entity->getModuleId());
        }
    }

    /**
     * @param string $id
     *
     * @return bool|null
     */
    private function isValidOrException(string $id): ? bool
    {
        if (!$this->repository->find($id) instanceof ProvinceInterface) {
            throw new NotFoundHttpException(sprintf('Province with id %s is not found.', $id));
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
