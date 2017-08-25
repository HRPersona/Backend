<?php

namespace Persona\Hris\Salary\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Persona\Hris\Salary\Model\SalaryHistoryInterface;
use Persona\Hris\Salary\Model\SalaryHistoryRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class InactiveSalaryHistorySubscriber implements EventSubscriber
{
    /**
     * @var SalaryHistoryRepositoryInterface
     */
    private $salaryHistoryRepository;

    /**
     * @param SalaryHistoryRepositoryInterface $salaryHistoryRepository
     */
    public function __construct(SalaryHistoryRepositoryInterface $salaryHistoryRepository)
    {
        $this->salaryHistoryRepository = $salaryHistoryRepository;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs): void
    {
        $salaryHistory = $eventArgs->getEntity();
        if ($salaryHistory instanceof SalaryHistoryInterface) {
            $this->salaryHistoryRepository->inactiveOthers($salaryHistory);
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs): void
    {
        $salaryHistory = $eventArgs->getEntity();
        if ($salaryHistory instanceof SalaryHistoryInterface) {
            $this->salaryHistoryRepository->inactiveOthers($salaryHistory);
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preRemove(LifecycleEventArgs $eventArgs): void
    {
        $salaryHistory = $eventArgs->getEntity();
        if ($salaryHistory instanceof SalaryHistoryInterface && $salaryHistory->isActive()) {
            throw new BadRequestHttpException('Can not remove active history.');
        }
    }

    /**
     * @return array
     */
    public function getSubscribedEvents(): array
    {
        return [Events::prePersist, Events::preUpdate, Events::preRemove];
    }
}
