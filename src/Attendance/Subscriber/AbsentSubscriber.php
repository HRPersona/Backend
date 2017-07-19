<?php

namespace Persona\Hris\Attendance\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Persona\Hris\Attendance\Model\EmployeeAbsentInterface;
use Persona\Hris\Attendance\Model\EmployeeAttendanceRepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class AbsentSubscriber implements EventSubscriber
{
    /**
     * @var EmployeeAttendanceRepositoryInterface
     */
    private $attendanceRepository;

    /**
     * @var EntityManager
     */
    private $manager;

    /**
     * @param EmployeeAttendanceRepositoryInterface $attendanceRepository
     */
    public function __construct(EmployeeAttendanceRepositoryInterface $attendanceRepository)
    {
        $this->attendanceRepository = $attendanceRepository;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs): void
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof EmployeeAbsentInterface) {
            $this->manager = $eventArgs->getEntityManager();
            $this->attendanceModification($entity);
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs): void
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof EmployeeAbsentInterface) {
            $this->manager = $eventArgs->getEntityManager();
            $this->attendanceModification($entity);
        }
    }

    /**
     * @param EmployeeAbsentInterface $employeeAbsent
     */
    private function attendanceModification(EmployeeAbsentInterface $employeeAbsent): void
    {
        $employeeAttendance = $this->attendanceRepository->findByEmployeeAndDate($employeeAbsent->getEmployee(), $employeeAbsent->getAbsentDate());
        if ($employeeAttendance) {
            $employeeAttendance->setAbsent(true);
            $employeeAttendance->setAbsentReason($employeeAbsent->getAbsentReason());
            $employeeAttendance->setRemark($employeeAbsent->getRemark());
        }

        $this->manager->persist($employeeAttendance);
    }

    /**
     * @return array
     */
    public function getSubscribedEvents(): array
    {
        return [Events::prePersist, Events::preUpdate];
    }
}
