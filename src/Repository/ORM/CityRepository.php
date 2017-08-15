<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Repository\AbstractRepository;
use Persona\Hris\Share\Model\CityInterface;
use Persona\Hris\Share\Model\CityRepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class CityRepository extends AbstractRepository implements CityRepositoryInterface
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
     * @return CityInterface|null
     */
    public function find(string $id): ? CityInterface
    {
        return $this->doFind($id);
    }
}
