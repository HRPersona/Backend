<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Repository\AbstractRepository;
use Persona\Hris\Share\Model\ProvinceInterface;
use Persona\Hris\Share\Model\ProvinceRepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class ProvinceRepository extends AbstractRepository implements ProvinceRepositoryInterface
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
     * @return ProvinceInterface|null
     */
    public function find(string $id): ? ProvinceInterface
    {
        return $this->doFind($id);
    }
}
