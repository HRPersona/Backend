<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Attendance\Model\AbsentReasonInterface;
use Persona\Hris\Attendance\Model\AbsentReasonRepositoryInterface;
use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Repository\AbstractRepository;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class AbsentReasonRepository extends AbstractRepository implements AbsentReasonRepositoryInterface
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
     * @return AbsentReasonInterface|null
     */
    public function find(string $id): ? AbsentReasonInterface
    {
        return $this->doFind($id);
    }
}
