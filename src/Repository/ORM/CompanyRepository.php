<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Organization\Model\CompanyInterface;
use Persona\Hris\Organization\Model\CompanyRepositoryInterface;
use Persona\Hris\Repository\AbstractRepository;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class CompanyRepository extends AbstractRepository implements CompanyRepositoryInterface
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
     * @return CompanyInterface|null
     */
    public function find(string $id): ? CompanyInterface
    {
        return $this->doFind($id);
    }
}
