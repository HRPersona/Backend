<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Attendance\Model\EmployeeShiftmentInterface;
use Persona\Hris\Attendance\Model\EmployeeShiftmentRepositoryInterface;
use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Repository\AbstractCachableRepository;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class EmployeeShiftmentRepository extends AbstractCachableRepository implements EmployeeShiftmentRepositoryInterface
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
     * @param \DateTime $shiftmentDate
     *
     * @return bool
     */
    public function isTimeOff(EmployeeInterface $employee, \DateTime $shiftmentDate): bool
    {
        $cache = $this->getCacheDriver();
        $cacheId = sprintf('%s_%s_%s', $this->class, $employee->getId(), $shiftmentDate->format('Ymd'));
        if ($cache->contains($cacheId)) {
            $data = $cache->fetch($cacheId);
            $this->managerFactory->merge([$data]);
        } else {
            /** @var EmployeeShiftmentInterface $data */
            $data = $this->managerFactory->getWriteManager()->getRepository($this->class)->findOneBy(['employee' => $employee, 'absentDate' => $shiftmentDate, 'deletedAt' => null]);
            $cache->save($cacheId, $data, $this->getCacheLifetime());
        }

        if (!$data) {
            return true;
        }

        return false;
    }
}
