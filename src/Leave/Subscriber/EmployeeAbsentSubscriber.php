<?php

namespace Persona\Hris\Leave\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Persona\Hris\Attendance\Model\EmployeeAbsentRepositoryInterface;
use Persona\Hris\Leave\Model\EmployeeLeaveBalanceInterface;
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
     * @var string
     */
    private $leaveBalanceClass;

    /**
     * @var EntityManager
     */
    private $manager;

    /**
     * @param EmployeeAbsentRepositoryInterface $absentRepository
     * @param string                            $leaveBalanceClass
     */
    public function __construct(EmployeeAbsentRepositoryInterface $absentRepository, string $leaveBalanceClass)
    {
        $this->absentRepository = $absentRepository;
        $this->leaveBalanceClass = $leaveBalanceClass;
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
            $this->updateLeaveBalance($entity);
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
            $employeeAbsent->setRemark($employeeLeave->getRemark());

            $this->manager->persist($employeeAbsent);
        }
    }

    /**
     * @param EmployeeLeaveInterface $employeeLeave
     */
    private function updateLeaveBalance(EmployeeLeaveInterface $employeeLeave): void
    {
        $employee = $employeeLeave->getEmployee();

        /** @var EmployeeLeaveBalanceInterface $leaveBalance */
        $leaveBalance = new $this->leaveBalanceClass();
        $leaveBalance->setEmployee($employee);
        $leaveBalance->setLeaveDay($employeeLeave->getLeaveDay());
        $leaveBalance->setLeaveBalance($leaveBalance->getLeaveBalance() - $leaveBalance->getLeaveDay());
        $leaveBalance->setRemark(sprintf('LEAVE_REQUEST{#ID:%s#EMPLOYEE:%s#NOTE:%s}', $employeeLeave->getId(), $employeeLeave->getEmployee()->getFullName(), $employeeLeave->getRemark()));

        $employee->setLeaveBalance($leaveBalance->getLeaveBalance());

        $this->manager->persist($leaveBalance);
    }

    /**
     * @return array
     */
    public function getSubscribedEvents(): array
    {
        return [Events::preUpdate];
    }
}
