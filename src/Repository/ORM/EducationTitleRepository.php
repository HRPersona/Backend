<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Repository\AbstractRepository;
use Persona\Hris\Share\Model\EducationTitleInterface;
use Persona\Hris\Share\Model\EducationTitleRepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class EducationTitleRepository extends AbstractRepository implements EducationTitleRepositoryInterface
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
     * @return EducationTitleInterface|null
     */
    public function find(string $id): ? EducationTitleInterface
    {
        return $this->doFind($id);
    }
}
