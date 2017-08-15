<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Repository\AbstractRepository;
use Persona\Hris\Salary\Model\BenefitInterface;
use Persona\Hris\Salary\Model\EmployeeBenefitRepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class EmployeeBenefitRepository extends AbstractRepository implements EmployeeBenefitRepositoryInterface
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
     *
     * @return BenefitInterface[]
     */
    public function findByEmployee(EmployeeInterface $employee): array
    {
        return $this->managerFactory->getWriteManager()->getRepository($this->class)->findBy(['employee' => $employee, 'deletedAt' => null]);
    }
}
