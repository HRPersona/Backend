<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Core\Security\Model\ServiceInterface;
use Persona\Hris\Core\Security\Model\ServiceRepositoryInterface;
use Persona\Hris\Repository\AbstractRepository;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class ServiceRepository extends AbstractRepository implements ServiceRepositoryInterface
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
     * @return ServiceInterface|null
     */
    public function find(string $id): ? ServiceInterface
    {
        return $this->doFind($id);
    }
}
