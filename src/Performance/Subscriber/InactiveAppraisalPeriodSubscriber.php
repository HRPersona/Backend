<?php

namespace Persona\Hris\Performance\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Persona\Hris\Performance\Model\AppraisalPeriodInterface;
use Persona\Hris\Performance\Model\AppraisalPeriodRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class InactiveAppraisalPeriodSubscriber implements EventSubscriber
{
    /**
     * @var AppraisalPeriodRepositoryInterface
     */
    private $appraisalPeriodRepository;

    /**
     * @param AppraisalPeriodRepositoryInterface $appriasalPeriodRepository
     */
    public function __construct(AppraisalPeriodRepositoryInterface $appriasalPeriodRepository)
    {
        $this->appraisalPeriodRepository = $appriasalPeriodRepository;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs): void
    {
        $appraisalPeriod = $eventArgs->getEntity();
        if ($appraisalPeriod instanceof AppraisalPeriodInterface) {
            $this->appraisalPeriodRepository->inactiveOthers($appraisalPeriod);
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs): void
    {
        $appraisalPeriod = $eventArgs->getEntity();
        if ($appraisalPeriod instanceof AppraisalPeriodInterface) {
            $this->appraisalPeriodRepository->inactiveOthers($appraisalPeriod);
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preRemove(LifecycleEventArgs $eventArgs): void
    {
        $appraisalPeriod = $eventArgs->getEntity();
        if ($appraisalPeriod instanceof AppraisalPeriodInterface && $appraisalPeriod->isActive()) {
            throw new BadRequestHttpException('Can not remove active period.');
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
