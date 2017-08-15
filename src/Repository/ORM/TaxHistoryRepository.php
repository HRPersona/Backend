<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Repository\AbstractRepository;
use Persona\Hris\Tax\Model\TaxHistoryInterface;
use Persona\Hris\Tax\Model\TaxHistoryRepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class TaxHistoryRepository extends AbstractRepository implements TaxHistoryRepositoryInterface
{
    /**
     * @param ManagerFactory $managerFactory
     * @param string         $class
     */
    public function __construct(ManagerFactory $managerFactory, string  $class)
    {
        parent::__construct($managerFactory, $class);
    }

    /**
     * @param EmployeeInterface $employee
     * @param int               $year
     * @param int               $month
     *
     * @return null|TaxHistoryInterface
     */
    public function findByEmployeeAndPeriod(EmployeeInterface $employee, int $year, int $month): ? TaxHistoryInterface
    {
        return $this->managerFactory->getWriteManager()->getRepository($this->class)->findOneBy(['employee' => $employee, 'taxYear' => $year, 'taxMonth' => $month, 'deletedAt' => null]);
    }
}
