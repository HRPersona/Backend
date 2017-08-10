<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Attendance\Model\ShiftmentInterface;
use Persona\Hris\Attendance\Model\ShiftmentRepositoryInterface;
use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Repository\AbstractRepository;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class ShiftmentRepository extends AbstractRepository implements ShiftmentRepositoryInterface
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
     * @return ShiftmentInterface|null
     */
    public function find(string $id): ? ShiftmentInterface
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
