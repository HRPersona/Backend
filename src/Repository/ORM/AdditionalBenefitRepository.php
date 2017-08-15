<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Repository\AbstractRepository;
use Persona\Hris\Salary\Model\AdditionalBenefitInterface;
use Persona\Hris\Salary\Model\AdditionalBenefitRepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class AdditionalBenefitRepository extends AbstractRepository implements AdditionalBenefitRepositoryInterface
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
     * @return AdditionalBenefitInterface[]
     */
    public function findByEmployee(EmployeeInterface $employee): array
    {
        return $this->managerFactory->getWriteManager()->getRepository($this->class)->findBy(['employee' => $employee, 'deletedAt' => null]);
    }
}
