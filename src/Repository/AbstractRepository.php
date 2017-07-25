<?php

namespace Persona\Hris\Repository;

use Persona\Hris\Core\Manager\ManagerFactory;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
abstract class AbstractRepository implements RepositoryInterface
{
    /**
     * @var ManagerFactory
     */
    protected $managerFactory;

    /**
     * @param ManagerFactory $managerFactory
     */
    public function __construct(ManagerFactory $managerFactory)
    {
        $this->managerFactory = $managerFactory;
    }
}
