<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Overtime\Model\EmployeeOvertimeHistoryInterface;
use Persona\Hris\Overtime\Model\EmployeeOvertimeHistoryRepositoryInterface;
use Persona\Hris\Repository\AbstractRepository;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class EmployeeOvertimeHistoryRepository extends AbstractRepository implements EmployeeOvertimeHistoryRepositoryInterface
{
    /**
     * @var string
     */
    private $class;

    /**
     * @var EmployeeOvertimeHistoryInterface
     */
    private $exist;

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
     * @param int               $year
     * @param int               $month
     *
     * @return bool
     */
    public function isExisting(EmployeeInterface $employee, int $year, int $month): bool
    {
        $this->exist = $this->managerFactory->getWriteManager()->getRepository($this->class)->findOneBy(['overtimeYear' => $year, 'overtimeMonth' => $month, 'employee' => $employee, 'deletedAt' => null]);
        if ($this->exist) {
            return true;
        }

        return false;
    }

    /**
     * @param EmployeeInterface $employee
     * @param int               $year
     * @param int               $month
     *
     * @return bool
     */
    public function isClosed(EmployeeInterface $employee, int $year, int $month): bool
    {
        $data = $this->managerFactory->getWriteManager()->getRepository($this->class)->findOneBy(['overtimeYear' => $year, 'overtimeMonth' => $month, 'closed' => true, 'employee' => $employee, 'deletedAt' => null]);
        if ($data) {
            return true;
        }

        return false;
    }

    /**
     * @param EmployeeInterface $employee
     * @param int               $year
     * @param int               $month
     *
     * @return float
     */
    public function getHistoryByEmployee(EmployeeInterface $employee, int $year, int $month): float
    {
        return $this->managerFactory->getWriteManager()->getRepository($this->class)->findOneBy(['overtimeYear' => $year, 'overtimeMonth' => $month, 'employee' => $employee, 'deletedAt' => null]);
    }

    /**
     * @return EmployeeOvertimeHistoryInterface
     */
    public function getExistData(): EmployeeOvertimeHistoryInterface
    {
        return $this->exist;
    }
}
