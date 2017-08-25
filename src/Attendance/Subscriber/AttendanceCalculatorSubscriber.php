<?php

namespace Persona\Hris\Attendance\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Persona\Hris\Attendance\AttendanceCalculator;
use Persona\Hris\Attendance\Model\EmployeeAttendanceInterface;
use Persona\Hris\Attendance\Model\EmployeeShiftmentRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class AttendanceCalculatorSubscriber implements EventSubscriber
{
    /**
     * @var EmployeeShiftmentRepositoryInterface
     */
    private $employeeShiftmentRepository;

    /**
     * @param EmployeeShiftmentRepositoryInterface $employeeShiftmentRepository
     */
    public function __construct(EmployeeShiftmentRepositoryInterface $employeeShiftmentRepository)
    {
        $this->employeeShiftmentRepository = $employeeShiftmentRepository;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs): void
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof EmployeeAttendanceInterface) {
            $this->setShiftment($entity);
            AttendanceCalculator::calculate($entity);
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs): void
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof EmployeeAttendanceInterface) {
            $this->setShiftment($entity);
            AttendanceCalculator::calculate($entity);
        }
    }

    /**
     * @param EmployeeAttendanceInterface $employeeAttendance
     */
    private function setShiftment(EmployeeAttendanceInterface $employeeAttendance)
    {
        $employeeShiftment = $this->employeeShiftmentRepository->findByEmployeeAndDate($employeeAttendance->getEmployee(), $employeeAttendance->getAttendanceDate());
        if (!$employeeShiftment) {
            throw new BadRequestHttpException(sprintf('%s doesn\'t has shiftment for %s', $employeeAttendance->getEmployee()->getFullName(), $employeeAttendance->getAttendanceDate()->format('d-m-Y')));
        }

        $employeeAttendance->setShiftment($employeeShiftment->getShiftment());
    }

    /**
     * @return array
     */
    public function getSubscribedEvents(): array
    {
        return [Events::prePersist, Events::preUpdate];
    }
}
