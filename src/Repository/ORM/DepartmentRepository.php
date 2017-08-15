<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Organization\Model\DepartmentInterface;
use Persona\Hris\Organization\Model\DepartmentRepositoryInterface;
use Persona\Hris\Repository\AbstractRepository;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class DepartmentRepository extends AbstractRepository implements DepartmentRepositoryInterface
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
     * @param string $id
     *
     * @return DepartmentInterface|null
     */
    public function find(string $id): ? DepartmentInterface
    {
        return $this->doFind($id);
    }
}
