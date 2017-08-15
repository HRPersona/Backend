<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Attendance\Model\ShiftmentInterface;
use Persona\Hris\Attendance\Model\ShiftmentRepositoryInterface;
use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Repository\AbstractRepository;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class ShiftmentRepository extends AbstractRepository implements ShiftmentRepositoryInterface
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
     * @return ShiftmentInterface|null
     */
    public function find(string $id): ? ShiftmentInterface
    {
        return $this->doFind($id);
    }
}
