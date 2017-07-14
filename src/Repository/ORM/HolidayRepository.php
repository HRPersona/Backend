<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Overtime\Model\HolidayInterface;
use Persona\Hris\Overtime\Model\HolidayRepositoryInterface;
use Persona\Hris\Repository\AbstractCachableRepository;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class HolidayRepository extends AbstractCachableRepository implements HolidayRepositoryInterface
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
     * @param \DateTime $date
     *
     * @return bool
     */
    public function isTimeOff(\DateTime $date): bool
    {
        $cache = $this->getCacheDriver();
        $cacheId = sprintf('%s_%s', $this->class, $date);
        if ($cache->contains($cacheId)) {
            $data = $cache->fetch($cacheId);
            $this->managerFactory->merge([$data]);
        } else {
            /** @var HolidayInterface $data */
            $data = $this->managerFactory->getWriteManager()->getRepository($this->class)->findOneBy(['holidayDate' => $date, 'deletedAt' => null]);
            $cache->save($cacheId, $data, $this->getCacheLifetime());
        }

        if (!$data) {
            return false;
        }

        return true;
    }
}
