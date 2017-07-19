<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Overtime\Model\EmployeeOvertimeCalculationInterface;
use Persona\Hris\Overtime\Model\EmployeeOvertimeCalculationRepositoryInterface;
use Persona\Hris\Repository\AbstractCachableRepository;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class EmployeeOvertimeCalculationRepository extends AbstractCachableRepository implements EmployeeOvertimeCalculationRepositoryInterface
{
    /**
     * @var string
     */
    private $class;

    /**
     * @var EmployeeOvertimeCalculationInterface
     */
    private $exist;

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
    public function isExisting(EmployeeInterface $employee, int $year, int $month): bool
    {
        $this->exist = $this->managerFactory->getWriteManager()->getRepository($this->class)->findOneBy(['year' => $year, 'month' => $month, 'employee' => $employee, 'deletedAt' => null]);
        if ($this->exist) {
            return true;
        }

        return false;
    }

    /**
     * @param EmployeeInterface $employee
     * @param int               $year
     * @param int               $month
     *
     * @return float
     */
    public function getCalculationByEmployee(EmployeeInterface $employee, int $year, int $month): float
    {
        $cache = $this->getCacheDriver();
        $cacheId = sprintf('%s_%s_%s_%s', $this->class, $employee->getId(), $year, $month);
        if ($cache->contains($cacheId)) {
            $data = $cache->fetch($cacheId);
            $this->managerFactory->merge([$data]);
        } else {
            /** @var EmployeeOvertimeCalculationInterface $data */
            $data = $this->managerFactory->getWriteManager()->getRepository($this->class)->findOneBy(['year' => $year, 'month' => $month, 'employee' => $employee, 'deletedAt' => null]);
            $cache->save($cacheId, $data, $this->getCacheLifetime());
        }

        return $data->getCalculatedValue();
    }

    /**
     * @return EmployeeOvertimeCalculationInterface
     */
    public function getExistData(): EmployeeOvertimeCalculationInterface
    {
        return $this->exist;
    }
}
