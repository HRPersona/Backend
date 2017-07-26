<?php

namespace Persona\Hris\Course\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Persona\Hris\Course\Model\CourseAttendanceInterface;
use Persona\Hris\Employee\Model\EmployeeCourseRepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class EmployeeCourseSubscriber implements EventSubscriber
{
    /**
     * @var EmployeeCourseRepositoryInterface
     */
    private $employeeCourseRepository;

    /**
     * @param EmployeeCourseRepositoryInterface $employeeRepository
     */
    public function __construct(EmployeeCourseRepositoryInterface $employeeRepository)
    {
        $this->employeeCourseRepository = $employeeRepository;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof CourseAttendanceInterface) {
            $employeeCourse = $this->employeeCourseRepository->createNew($entity->getEmployee(), $entity->getCourse());
            $employeeCourse->setCertificateNumber($entity->getCertificateNumber());
            $employeeCourse->setCertificateFile($entity->getCertificateFile());

            $manager = $eventArgs->getEntityManager();

            $manager->persist($employeeCourse);
            $manager->flush();
        }
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preRemove(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof CourseAttendanceInterface) {
            $employeeCourse = $this->employeeCourseRepository->findByEmployeeCourse($entity->getEmployee(), $entity->getCourse());

            $manager = $eventArgs->getEntityManager();

            $manager->remove($employeeCourse);
            $manager->flush();
        }
    }

    /**
     * @return array
     */
    public function getSubscribedEvents(): array
    {
        return [Events::prePersist, Events::preRemove];
    }
}
