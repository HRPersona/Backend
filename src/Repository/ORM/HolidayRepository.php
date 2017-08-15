<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Overtime\Model\HolidayInterface;
use Persona\Hris\Overtime\Model\HolidayRepositoryInterface;
use Persona\Hris\Repository\AbstractRepository;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class HolidayRepository extends AbstractRepository implements HolidayRepositoryInterface
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
     * @param \DateTime $date
     *
     * @return bool
     */
    public function isTimeOff(\DateTime $date): bool
    {
        /** @var HolidayInterface $data */
        $data = $this->managerFactory->getWriteManager()->getRepository($this->class)->findOneBy(['holidayDate' => $date, 'deletedAt' => null]);
        if (!$data) {
            return false;
        }

        return true;
    }
}
