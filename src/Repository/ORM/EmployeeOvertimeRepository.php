<?php

namespace Persona\Hris\Repository\ORM;

use Doctrine\ORM\EntityRepository;
use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Overtime\Model\EmployeeOvertimeInterface;
use Persona\Hris\Overtime\Model\EmployeeOvertimeRepositoryInterface;
use Persona\Hris\Repository\AbstractRepository;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class EmployeeOvertimeRepository extends AbstractRepository implements EmployeeOvertimeRepositoryInterface
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
     * @param \DateTime         $date
     * @param EmployeeInterface $employee
     *
     * @return EmployeeOvertimeInterface[]
     */
    public function findByEmployee(\DateTime $date, EmployeeInterface $employee): array
    {
        /** @var EntityRepository $repository */
        $repository = $this->managerFactory->getWriteManager()->getRepository($this->class);
        $queryBuilder = $repository->createQueryBuilder('eo');
        $queryBuilder->andWhere($queryBuilder->expr()->gte('eo.overtimeDate', $queryBuilder->expr()->literal(sprintf('%s-01', $date->format('Y-m')))));
        $queryBuilder->andWhere($queryBuilder->expr()->lte('eo.overtimeDate', $queryBuilder->expr()->literal($date->format('Y-m-t'))));
        $queryBuilder->andWhere($queryBuilder->expr()->eq('eo.employee', $queryBuilder->expr()->literal($employee->getId())));
        $queryBuilder->andWhere($queryBuilder->expr()->isNull('eo.deletedAt'));

        return $queryBuilder->getQuery()->getResult();
    }
}
