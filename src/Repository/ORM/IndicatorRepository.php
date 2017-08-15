<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Performance\Model\IndicatorInterface;
use Persona\Hris\Performance\Model\IndicatorRepositoryInterface;
use Persona\Hris\Repository\AbstractRepository;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class IndicatorRepository extends AbstractRepository implements IndicatorRepositoryInterface
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
     * @return IndicatorInterface|null
     */
    public function find(string $id): ? IndicatorInterface
    {
        return $this->doFind($id);
    }
}
