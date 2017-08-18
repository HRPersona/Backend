<?php

namespace Persona\Hris\Repository\ORM;

use Doctrine\ORM\EntityRepository;
use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Performance\Model\AppraisalPeriodInterface;
use Persona\Hris\Performance\Model\AppraisalPeriodRepositoryInterface;
use Persona\Hris\Repository\AbstractRepository;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class AppraisalPeriodRepository extends AbstractRepository implements AppraisalPeriodRepositoryInterface
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

    /**
     * @param string $id
     *
     * @return null|AppraisalPeriodInterface
     */
    public function find(string $id): ? AppraisalPeriodInterface
    {
        return $this->doFind($id);
    }
}
