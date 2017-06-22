<?php

namespace Persona\Hris\Leave\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Persona\Hris\Attendance\Model\EmployeeAbsentRepositoryInterface;
use Persona\Hris\Leave\Model\EmployeeLeaveInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class EmployeeAbsentSubscriber implements EventSubscriber
{
    /**
     * @var EmployeeAbsentRepositoryInterface
     */
    private $absentRepository;

    /**
     * @var EntityManager
     */
    private $manager;

    /**
     * @param EmployeeAbsentRepositoryInterface $absentRepository
     */
    public function __construct(EmployeeAbsentRepositoryInterface $absentRepository)
    {
        $this->absentRepository = $absentRepository;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs): void
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof EmployeeLeaveInterface && $entity->isApproved()) {
            $this->manager = $eventArgs->getEntityManager();
            $this->absentModication($entity);
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs): void
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof EmployeeLeaveInterface && $entity->isApproved()) {
            $this->manager = $eventArgs->getEntityManager();
            $this->absentModication($entity);
        }
    }

    /**
     * @param EmployeeLeaveInterface $employeeLeave
     */
    private function absentModication(EmployeeLeaveInterface $employeeLeave): void
    {
        for ($i = 0; $i < $employeeLeave->getLeaveDay(); ++$i) {
            $leaveDate = $employeeLeave->getLeaveDate()->add(new \DateInterval(sprintf('P%sD', $i)));

            $employeeAbsent = $this->absentRepository->findByEmployeeAndDate($employeeLeave->getEmployee(), $leaveDate);
            $employeeAbsent->setAbsentReason($employeeLeave->getLeave()->getAbsentReason());
            if ($remark = $employeeLeave->getRemark()) {
                $employeeAbsent->setRemark($remark);
            }

            $this->manager->persist($employeeAbsent);
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
