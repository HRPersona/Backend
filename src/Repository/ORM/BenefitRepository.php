<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Repository\AbstractRepository;
use Persona\Hris\Salary\Model\BenefitInterface;
use Persona\Hris\Salary\Model\BenefitRepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class BenefitRepository extends AbstractRepository implements BenefitRepositoryInterface
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
     * @return BenefitInterface|null
     */
    public function find(string $id): ? BenefitInterface
    {
        return $this->doFind($id);
    }
}
