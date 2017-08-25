<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Allocation\Model\ResignReasonInterface;
use Persona\Hris\Allocation\Model\ResignReasonRepositoryInterface;
use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Repository\AbstractRepository;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class ResignReasonRepository extends AbstractRepository implements ResignReasonRepositoryInterface
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
     * @return ResignReasonInterface|null
     */
    public function find(string $id): ? ResignReasonInterface
    {
        return $this->doFind($id);
    }
}
