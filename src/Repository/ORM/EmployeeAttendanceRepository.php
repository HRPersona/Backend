<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Attendance\Model\EmployeeAttendanceInterface;
use Persona\Hris\Attendance\Model\EmployeeAttendanceRepositoryInterface;
use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Repository\AbstractRepository;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class EmployeeAttendanceRepository extends AbstractRepository implements EmployeeAttendanceRepositoryInterface
{
    /**
     * @var string
     */
    private $class;

    /**
     * @param ManagerFactory $managerFactory
     * @param string         $class
     */
    public function __construct(ManagerFactory $managerFactory, string  $class)
    {
        parent::__construct($managerFactory);
        $this->class = $class;
    }

    /**
     * When record is not found then create new object.
     *
     * @param EmployeeInterface $employee
     * @param \DateTime         $attendanceDate
     *
     * @return EmployeeAttendanceInterface
     */
    public function findByEmployeeAndDate(EmployeeInterface $employee, \DateTime $attendanceDate): EmployeeAttendanceInterface
    {
        /** @var EmployeeAttendanceInterface $data */
        $data = $this->managerFactory->getWriteManager()->getRepository($this->class)->findOneBy(['employeeId' => $employee, 'absentDate' => $attendanceDate, 'deletedAt' => null]);
        if (!$data) {
            $data = new $this->class();
            $data->setEmployee($employee);
            $data->setAttendanceDate($attendanceDate);
        }

        return $data;
    }
}
