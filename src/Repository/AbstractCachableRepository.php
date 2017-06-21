<?php

namespace Persona\Hris\Repository;

use Doctrine\Common\Cache\Cache;
use Persona\Hris\Core\Manager\ManagerFactory;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@bisnis.com>
 */
abstract class AbstractCachableRepository implements CachableRepositoryInterface
{
    /**
     * @var ManagerFactory
     */
    protected $managerFactory;

    /**
     * @var int
     */
    private $cacheLifetime;

    /**
     * @param ManagerFactory $managerFactory
     */
    public function __construct(ManagerFactory $managerFactory)
    {
        $this->managerFactory = $managerFactory;
        $this->cacheLifetime = 0;
    }

    /**
     * @param int $cacheLifetime
     */
    public function setCacheLifetime(int $cacheLifetime)
    {
        $this->cacheLifetime = $cacheLifetime;
    }

    /**
     * @return Cache
     */
    public function getCacheDriver(): Cache
    {
        return $this->managerFactory->getCacheDriver();
    }

    /**
     * @return int
     */
    public function getCacheLifetime(): int
    {
        return $this->cacheLifetime;
    }
}
