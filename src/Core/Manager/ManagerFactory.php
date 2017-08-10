<?php

namespace Persona\Hris\Core\Manager;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Proxy\Exception\InvalidArgumentException;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class ManagerFactory
{
    /**
     * @var Registry
     */
    private $readRegistry;

    /**
     * @var Registry
     */
    private $writeRegistry;

    /**
     * @var ArrayCache
     */
    private $cache;

    /**
     * @param array $registies
     */
    public function __construct(array $registies)
    {
        if (!array_key_exists('read', $registies) || !array_key_exists('write', $registies)) {
            throw new InvalidArgumentException('Invalid Doctrine Registry.');
        }

        $this->readRegistry = $registies['read'];
        $this->writeRegistry = $registies['write'];
    }

    /**
     * @return Cache
     */
    public function getCacheDriver()
    {
        if (null === $this->cache) {
            $this->cache = new ArrayCache();
        }

        return $this->cache;
    }

    /**
     * @return Registry
     */
    public function getWriteRegistry(): Registry
    {
        return $this->writeRegistry;
    }

    /**
     * @return Registry
     */
    public function getReadRegistry(): Registry
    {
        return $this->readRegistry;
    }

    /**
     * @return ObjectManager|object
     */
    public function getReadManager(): ObjectManager
    {
        return $this->readRegistry->getManager();
    }

    /**
     * @return ObjectManager|object
     */
    public function getWriteManager(): ObjectManager
    {
        return $this->writeRegistry->getManager();
    }

    /**
     * @param array $objects
     */
    public function merge(array $objects)
    {
        $readManager = $this->getReadManager();
        $writeManager = $this->getWriteManager();
        foreach ($objects as $object) {
            if ($object) {
                $readManager->merge($object);
                $writeManager->merge($object);
            }
        }
    }
}
