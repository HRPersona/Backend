<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Repository\AbstractCachableRepository;
use Persona\Hris\Salary\Model\AdditionalBenefitInterface;
use Persona\Hris\Salary\Model\AdditionalBenefitRepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class AdditionalBenefitRepository extends AbstractCachableRepository implements AdditionalBenefitRepositoryInterface
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
     *
     * @return AdditionalBenefitInterface[]
     */
    public function findByEmployee(EmployeeInterface $employee): array
    {
        $cache = $this->getCacheDriver();
        $cacheId = sprintf('%s_%s', $this->class, $employee->getId());
        if ($cache->contains($cacheId)) {
            $data = $cache->fetch($cacheId);
            $this->managerFactory->merge([$data]);
        } else {
            /** @var AdditionalBenefitInterface $repository */
            $data = $this->managerFactory->getWriteManager()->getRepository($this->class)->findBy(['employee' => $employee, 'deletedAt' => null]);
            $cache->save($cacheId, $data, $this->getCacheLifetime());
        }

        return $data;
    }
}
