<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Repository\AbstractCachableRepository;
use Persona\Hris\Salary\Model\PayrollRepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
class PayrollRepository extends AbstractCachableRepository implements PayrollRepositoryInterface
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
     * @param int $year
     * @param int $month
     *
     * @return bool
     */
    public function isClosed(EmployeeInterface $employee, int $year, int $month): bool
    {
        $data = $this->managerFactory->getWriteManager()->getRepository($this->class)->findOneBy(['year' => $year, 'month' => $month, 'closed' => true, 'employee' => $employee, 'deletedAt' => null]);
        if ($data) {
            return true;
        }

        return false;
    }
}
