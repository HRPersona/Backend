<?php

namespace Persona\Hris\Repository;

use Doctrine\Common\Cache\Cache;
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
     * @var string
     */
    protected $class;

    /**
     * @param ManagerFactory $managerFactory
     * @param string $class
     */
    public function __construct(ManagerFactory $managerFactory, string $class)
    {
        $this->managerFactory = $managerFactory;
        $this->class = $class;
    }

    /**
     * @param string $id
     *
     * @return mixed|null
     */
    protected function doFind(string $id)
    {
        $cache = $this->managerFactory->getCacheDriver();
        try {
            if ($cache->contains($this->class)) {
                $data = $cache->fetch($this->class);
                $this->managerFactory->merge([$data]);

                return $data;
            }

            return $this->fecth($cache, $id);
        } catch (\Exception $exception) {

            return $this->fecth($cache, $id);
        }
    }

    /**
     * @param Cache $cache
     * @param string $id
     *
     * @return null|object
     */
    private function fecth(Cache $cache, string $id)
    {
        $data = $this->managerFactory->getWriteManager()->getRepository($this->class)->findOneBy(['id' => $id, 'deletedAt' => null]);
        if ($data) {
            $cache->save($this->class, $data);
        }

        return $data;
    }
}
