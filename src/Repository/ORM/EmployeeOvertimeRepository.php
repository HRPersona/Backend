<?php

namespace Persona\Hris\Repository\ORM;

use Doctrine\ORM\EntityRepository;
use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Overtime\Model\EmployeeOvertimeInterface;
use Persona\Hris\Overtime\Model\EmployeeOvertimeRepositoryInterface;
use Persona\Hris\Repository\AbstractCachableRepository;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class EmployeeOvertimeRepository extends AbstractCachableRepository implements EmployeeOvertimeRepositoryInterface
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
     * @param \DateTime         $date
     * @param EmployeeInterface $employee
     *
     * @return EmployeeOvertimeInterface[]
     */
    public function findByEmployee(\DateTime $date, EmployeeInterface $employee): array
    {
        $cache = $this->getCacheDriver();
        $cacheId = sprintf('%s_%s', $this->class, $employee->getId());
        if ($cache->contains($cacheId)) {
            $data = $cache->fetch($cacheId);
            $this->managerFactory->merge([$data]);
        } else {
            /** @var EntityRepository $repository */
            $repository = $this->managerFactory->getWriteManager()->getRepository($this->class);
            $queryBuilder = $repository->createQueryBuilder('eo');
            $queryBuilder->andWhere($queryBuilder->expr()->gte('eo.overtimeDate', $queryBuilder->expr()->literal(sprintf('%s-01', $date->format('Y-m')))));
            $queryBuilder->andWhere($queryBuilder->expr()->lte('eo.overtimeDate', $queryBuilder->expr()->literal($date->format('Y-m-t'))));
            $queryBuilder->andWhere($queryBuilder->expr()->eq('eo.employee', $queryBuilder->expr()->literal($employee->getId())));
            $queryBuilder->andWhere($queryBuilder->expr()->isNull('eo.deletedAt'));

            /** @var EmployeeOvertimeInterface[] $data */
            $data = $queryBuilder->getQuery()->getResult();
            $cache->save($cacheId, $data, $this->getCacheLifetime());
        }

        return $data;
    }
}
