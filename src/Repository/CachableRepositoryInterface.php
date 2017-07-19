<?php

namespace Persona\Hris\Repository;

use Doctrine\Common\Cache\Cache;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface CachableRepositoryInterface extends RepositoryInterface
{
    /**
     * @return Cache
     */
    public function getCacheDriver(): Cache;

    /**
     * @return int
     */
    public function getCacheLifetime(): int;
}
