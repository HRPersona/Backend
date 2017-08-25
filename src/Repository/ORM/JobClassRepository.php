<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Organization\Model\JobClassInterface;
use Persona\Hris\Organization\Model\JobClassRepositoryInterface;
use Persona\Hris\Repository\AbstractRepository;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class JobClassRepository extends AbstractRepository implements JobClassRepositoryInterface
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
     * @return JobClassInterface|null
     */
    public function find(string $id): ? JobClassInterface
    {
        return $this->doFind($id);
    }
}
