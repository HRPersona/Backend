<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Leave\Model\LeaveInterface;
use Persona\Hris\Leave\Model\LeaveRepositoryInterface;
use Persona\Hris\Repository\AbstractRepository;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class LeaveRepository extends AbstractRepository implements LeaveRepositoryInterface
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
     * @return LeaveInterface|null
     */
    public function find(string $id): ? LeaveInterface
    {
        return $this->doFind($id);
    }
}
