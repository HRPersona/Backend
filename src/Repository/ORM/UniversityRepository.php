<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Repository\AbstractRepository;
use Persona\Hris\Share\Model\UniversityInterface;
use Persona\Hris\Share\Model\UniversityRepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class UniversityRepository extends AbstractRepository implements UniversityRepositoryInterface
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
     * @return UniversityInterface|null
     */
    public function find(string $id): ? UniversityInterface
    {
        return $this->doFind($id);
    }
}
