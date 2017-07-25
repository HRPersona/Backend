<?php

namespace Persona\Hris\Salary\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Persona\Hris\Salary\Model\PayrollInterface;
use Persona\Hris\Salary\Model\PayrollRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class PreventReopenPayrollSubscriber implements EventSubscriber
{
    /**
     * @var PayrollRepositoryInterface
     */
    private $payrollRepository;

    /**
     * @param PayrollRepositoryInterface $payrollRepository
     */
    public function __construct(PayrollRepositoryInterface $payrollRepository)
    {
        $this->payrollRepository = $payrollRepository;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof PayrollInterface) {
            $persistence = $this->payrollRepository->find($entity->getId());
            if ($persistence->isClosed() && !$entity->isClosed()) {
                throw new BadRequestHttpException(sprintf('Can not reopen closed payroll.'));
            }
        }
    }

    /**
     * @return array
     */
    public function getSubscribedEvents(): array
    {
        return [Events::preUpdate];
    }
}
