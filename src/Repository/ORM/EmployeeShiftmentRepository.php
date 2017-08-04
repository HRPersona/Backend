<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Attendance\Model\EmployeeShiftmentInterface;
use Persona\Hris\Attendance\Model\EmployeeShiftmentRepositoryInterface;
use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Repository\AbstractRepository;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class EmployeeShiftmentRepository extends AbstractRepository implements EmployeeShiftmentRepositoryInterface
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
     * @param EmployeeInterface $employee
     * @param \DateTime         $shiftmentDate
     *
     * @return bool
     */
    public function isTimeOff(EmployeeInterface $employee, \DateTime $shiftmentDate): bool
    {
        /** @var EmployeeShiftmentInterface $data */
        $data = $this->managerFactory->getWriteManager()->getRepository($this->class)->findOneBy(['employee' => $employee, 'absentDate' => $shiftmentDate, 'deletedAt' => null]);
        if (!$data) {
            return true;
        }

        return false;
    }
}
