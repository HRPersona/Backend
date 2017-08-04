<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Attendance\Model\EmployeeAbsentInterface;
use Persona\Hris\Attendance\Model\EmployeeAbsentRepositoryInterface;
use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Repository\AbstractRepository;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class EmployeeAbsentRepository extends AbstractRepository implements EmployeeAbsentRepositoryInterface
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
     * @param \DateTime         $absentDate
     *
     * @return EmployeeAbsentInterface
     */
    public function findByEmployeeAndDate(EmployeeInterface $employee, \DateTime $absentDate): EmployeeAbsentInterface
    {
        /** @var EmployeeAbsentInterface $data */
        $data = $this->managerFactory->getWriteManager()->getRepository($this->class)->findOneBy(['employee' => $employee, 'absentDate' => $absentDate, 'deletedAt' => null]);
        if (!$data) {
            $data = new $this->class();
            $data->setEmployee($employee);
            $data->setAbsentDate($absentDate);
        }

        return $data;
    }
}
