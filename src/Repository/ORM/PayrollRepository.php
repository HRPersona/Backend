<?php

namespace Persona\Hris\Repository\ORM;

use Doctrine\ORM\EntityRepository;
use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Repository\AbstractRepository;
use Persona\Hris\Salary\Model\PayrollInterface;
use Persona\Hris\Salary\Model\PayrollRepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class PayrollRepository extends AbstractRepository implements PayrollRepositoryInterface
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
     * @param int               $year
     * @param int               $month
     *
     * @return bool
     */
    public function isClosed(EmployeeInterface $employee, int $year, int $month): bool
    {
        $data = $this->managerFactory->getWriteManager()->getRepository($this->class)->findOneBy(['payrollYear' => $year, 'payrollMonth' => $month, 'closed' => true, 'employee' => $employee, 'deletedAt' => null]);
        if ($data) {
            return true;
        }

        return false;
    }

    /**
     * @param int $year
     * @param int $month
     */
    public function closingPeriod(int $year, int $month): void
    {
        /** @var EntityRepository $repository */
        $repository = $this->managerFactory->getWriteManager()->getRepository($this->class);

        $queryBuilder = $repository->createQueryBuilder('o');
        $queryBuilder->update();
        $queryBuilder->set('o.closed', $queryBuilder->expr()->literal(true));
        $queryBuilder->andWhere($queryBuilder->expr()->eq('o.payrollYear', $queryBuilder->expr()->literal($year)));
        $queryBuilder->andWhere($queryBuilder->expr()->eq('o.payrollMonth', $queryBuilder->expr()->literal($month)));

        $queryBuilder->getQuery()->execute();
    }

    /**
     * @param string $id
     *
     * @return null|PayrollInterface
     */
    public function find(string $id): ? PayrollInterface
    {
        return $this->managerFactory->getReadManager()->getRepository($this->class)->find($id);
    }

    /**
     * @param EmployeeInterface $employee
     * @param int               $year
     * @param int               $month
     *
     * @return null|PayrollInterface
     */
    public function findByEmployeeAndPeriod(EmployeeInterface $employee, int $year, int $month): ? PayrollInterface
    {
        return $this->managerFactory->getWriteManager()->getRepository($this->class)->findOneBy(['employee' => $employee, 'payrollYear' => $year, 'payrollMonth' => $month, 'deletedAt' => null]);
    }
}
