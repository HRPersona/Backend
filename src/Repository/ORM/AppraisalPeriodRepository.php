<?php

namespace Persona\Hris\Repository\ORM;

use Doctrine\ORM\EntityRepository;
use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Performance\Model\AppraisalPeriodInterface;
use Persona\Hris\Performance\Model\AppraisalPeriodRepositoryInterface;
use Persona\Hris\Repository\AbstractCachableRepository;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class AppraisalPeriodRepository extends AbstractCachableRepository implements AppraisalPeriodRepositoryInterface
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
     * @param AppraisalPeriodInterface $appraisalPeriod
     */
    public function inactiveOthers(AppraisalPeriodInterface $appraisalPeriod): void
    {
        /** @var EntityRepository $repository */
        $repository = $this->managerFactory->getWriteManager()->getRepository($this->class);

        $queryBuilder = $repository->createQueryBuilder('o');
        $queryBuilder->update();
        $queryBuilder->set('o.active', $queryBuilder->expr()->literal(false));
        $queryBuilder->andWhere($queryBuilder->expr()->neq('o.id', $queryBuilder->expr()->literal($appraisalPeriod->getId())));

        $queryBuilder->getQuery()->execute();
    }
}
