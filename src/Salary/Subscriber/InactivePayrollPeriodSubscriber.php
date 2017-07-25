<?php

namespace Persona\Hris\Salary\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Persona\Hris\Salary\Model\PayrollPeriodInterface;
use Persona\Hris\Salary\Model\PayrollPeriodRepositoryInterface;
use Persona\Hris\Salary\Model\PayrollRepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class InactivePayrollPeriodSubscriber implements EventSubscriber
{
    /**
     * @var PayrollPeriodRepositoryInterface
     */
    private $payrollPeriodRepository;

    /**
     * @var PayrollRepositoryInterface
     */
    private $payrollRepository;

    /**
     * @param PayrollPeriodRepositoryInterface $payrollPeriodRepository
     * @param PayrollRepositoryInterface       $payrollRepository
     */
    public function __construct(PayrollPeriodRepositoryInterface $payrollPeriodRepository, PayrollRepositoryInterface $payrollRepository)
    {
        $this->payrollPeriodRepository = $payrollPeriodRepository;
        $this->payrollRepository = $payrollRepository;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs): void
    {
        $payrollPeriod = $eventArgs->getEntity();
        if ($payrollPeriod instanceof PayrollPeriodInterface) {
            $this->payrollPeriodRepository->inactiveOthers($payrollPeriod);
            $this->payrollRepository->closingPeriod($payrollPeriod->getPayrollYear(), $payrollPeriod->getPayrollMonth());
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs): void
    {
        $payrollPeriod = $eventArgs->getEntity();
        if ($payrollPeriod instanceof PayrollPeriodInterface) {
            $this->payrollPeriodRepository->inactiveOthers($payrollPeriod);
            $this->payrollRepository->closingPeriod($payrollPeriod->getPayrollYear(), $payrollPeriod->getPayrollMonth());
        }
    }

    /**
     * @return array
     */
    public function getSubscribedEvents(): array
    {
        return [Events::prePersist, Events::preUpdate];
    }
}
