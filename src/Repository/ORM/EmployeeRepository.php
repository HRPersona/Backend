<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Employee\Model\EmployeeRepositoryInterface;
use Persona\Hris\Repository\AbstractRepository;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class EmployeeRepository extends AbstractRepository implements EmployeeRepositoryInterface
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
        return $this->managerFactory->getWriteManager()->getRepository($this->class)->findBy(['resign' => false, 'deletedAt' => null]);
    }

    /**
     * @param string $id
     *
     * @return null|EmployeeInterface
     */
    public function find(string $id): ? EmployeeInterface
    {
        return $this->managerFactory->getWriteManager()->getRepository($this->class)->find($id);
    }
}
