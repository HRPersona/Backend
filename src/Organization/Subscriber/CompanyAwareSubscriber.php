<?php

namespace Persona\Hris\Organization\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Persona\Hris\Organization\Model\CompanyAwareInterface;
use Persona\Hris\Organization\Model\CompanyInterface;
use Persona\Hris\Organization\Model\CompanyRepositoryInterface;
use Persona\Hris\Organization\Model\ParentCompanyAwareInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class CompanyAwareSubscriber implements EventSubscriber
{
    /**
     * @var CompanyRepositoryInterface
     */
    private $repository;

    /**
     * @param CompanyRepositoryInterface $repository
     */
    public function __construct(CompanyRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof CompanyAwareInterface) {
            $this->isValidOrException($entity->getCompanyId());
        }

        if ($entity instanceof ParentCompanyAwareInterface) {
            $this->isValidOrException($entity->getParentId());
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof CompanyAwareInterface) {
            $this->isValidOrException($entity->getCompanyId());
        }

        if ($entity instanceof ParentCompanyAwareInterface) {
            $this->isValidOrException($entity->getParentId());
        }
    }

    /**
     * @param string $id
     *
     * @return bool|null
     */
    private function isValidOrException(string $id): ? bool
    {
        if (!$this->repository->find($id) instanceof CompanyInterface) {
            throw new NotFoundHttpException(sprintf('Company with id %s is not found.', $id));
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
