<?php

namespace Persona\Hris\Repository\ORM;

use Doctrine\ORM\EntityRepository;
use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Repository\AbstractRepository;
use Persona\Hris\Salary\Model\SalaryHistoryInterface;
use Persona\Hris\Salary\Model\SalaryHistoryRepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class SalaryHistoryRepository extends AbstractRepository implements SalaryHistoryRepositoryInterface
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
     * @param SalaryHistoryInterface $salaryHistory
     */
    public function inactiveOthers(SalaryHistoryInterface $salaryHistory): void
    {
        /** @var EntityRepository $repository */
        $repository = $this->managerFactory->getWriteManager()->getRepository($this->class);

        $queryBuilder = $repository->createQueryBuilder('o');
        $queryBuilder->update();
        $queryBuilder->set('o.active', $queryBuilder->expr()->literal(false));
        $queryBuilder->andWhere($queryBuilder->expr()->neq('o.id', $queryBuilder->expr()->literal($salaryHistory->getId())));

        $queryBuilder->getQuery()->execute();
    }
}
