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
     * @return IndicatorInterface|null
     */
    public function find(string $id): ? IndicatorInterface
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
