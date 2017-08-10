<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Repository\AbstractRepository;
use Persona\Hris\Share\Model\ProvinceInterface;
use Persona\Hris\Share\Model\ProvinceRepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class ProvinceRepository extends AbstractRepository implements ProvinceRepositoryInterface
{
    /**
     * @var string
     */
    private $class;

    /**
     * @param ManagerFactory $managerFactory
     * @param string         $class
     */
    public function __construct(ManagerFactory $managerFactory, string  $class)
    {
        parent::__construct($managerFactory);
        $this->class = $class;
    }

    /**
     * @param string $id
     *
     * @return ProvinceInterface|null
     */
    public function find(string $id): ? ProvinceInterface
    {
        $cache = $this->managerFactory->getCacheDriver();
        if ($cache->contains($this->class)) {
            $data = $cache->fetch($this->class);
            $this->managerFactory->merge([$data]);

            return $data;
        }

        $data = $this->managerFactory->getWriteManager()->getRepository($this->class)->findOneBy(['id' => $id, 'deletedAt' => null]);
        if ($data) {
            $cache->save($this->class, $data);
        }

        return $data;
    }
}
