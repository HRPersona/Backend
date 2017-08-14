<?php

namespace Persona\Hris\Salary\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Persona\Hris\Salary\Model\BenefitAwareInterface;
use Persona\Hris\Salary\Model\BenefitInterface;
use Persona\Hris\Salary\Model\BenefitRepositoryInterface;
use Persona\Hris\Salary\Model\MinusBenefitAwareInterface;
use Persona\Hris\Salary\Model\PlusBenefitAwareInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class BenefitAwareSubscriber implements EventSubscriber
{
    /**
     * @var BenefitRepositoryInterface
     */
    private $repository;

    /**
     * @param BenefitRepositoryInterface $repository
     */
    public function __construct(BenefitRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof BenefitAwareInterface) {
            $this->isValidOrException($entity->getBenefitId());
        }

        if ($entity instanceof PlusBenefitAwareInterface) {
            $this->isValidOrException($entity->getPlusBenefitId());
        }

        if ($entity instanceof MinusBenefitAwareInterface) {
            $this->isValidOrException($entity->getMinusBenefitId());
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof BenefitAwareInterface) {
            $this->isValidOrException($entity->getBenefitId());
        }

        if ($entity instanceof PlusBenefitAwareInterface) {
            $this->isValidOrException($entity->getPlusBenefitId());
        }

        if ($entity instanceof MinusBenefitAwareInterface) {
            $this->isValidOrException($entity->getMinusBenefitId());
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function postLoad(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof BenefitAwareInterface) {
            $entity->setBenefit($this->repository->find($entity->getBenefitId()));
        }

        if ($entity instanceof PlusBenefitAwareInterface) {
            $entity->setPlusBenefit($this->repository->find($entity->getPlusBenefitId()));
        }

        if ($entity instanceof MinusBenefitAwareInterface) {
            $entity->setMinusBenefit($this->repository->find($entity->getMinusBenefitId()));
        }
    }

    /**
     * @param string $id
     *
     * @return bool|null
     */
    private function isValidOrException(string $id): ? bool
    {
        if (!$this->repository->find($id) instanceof BenefitInterface) {
            throw new NotFoundHttpException(sprintf('Benefit with id %s is not found.', $id));
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
