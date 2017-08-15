<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Organization\Model\JobTitleInterface;
use Persona\Hris\Organization\Model\JobTitleRepositoryInterface;
use Persona\Hris\Repository\AbstractRepository;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class JobTitleRepository extends AbstractRepository implements JobTitleRepositoryInterface
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
     * @return JobTitleInterface|null
     */
    public function find(string $id): ? JobTitleInterface
    {
        return $this->doFind($id);
    }
}
