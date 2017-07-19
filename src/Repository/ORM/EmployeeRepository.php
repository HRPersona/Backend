<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Employee\Model\EmployeeRepositoryInterface;
use Persona\Hris\Repository\AbstractCachableRepository;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class EmployeeRepository extends AbstractCachableRepository implements EmployeeRepositoryInterface
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
     * @return EmployeeInterface[]
     */
    public function findActiveEmployee(): array
    {
        $cache = $this->getCacheDriver();
        $cacheId = sprintf('%s_%s', $this->class, 'active');
        if ($cache->contains($cacheId)) {
            $data = $cache->fetch($cacheId);
            $this->managerFactory->merge([$data]);
        } else {
            $data = $this->managerFactory->getWriteManager()->getRepository($this->class)->findBy(['resign' => true, 'deletedAt' => null]);
            $cache->save($cacheId, $data, $this->getCacheLifetime());
        }

        return $data;
    }
}
