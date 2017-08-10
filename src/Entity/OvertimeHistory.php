<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Core\Logger\Model\ActionLoggerAwareInterface;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Overtime\Model\EmployeeOvertimeHistoryInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity()
 * @ORM\Table(name="ov_overtime_histories")
 *
 * @ApiResource(
 *     attributes={
 *         "filters"={"order.filter"},
 *         "normalization_context"={"groups"={"read"}},
 *         "denormalization_context"={"groups"={"write"}}
 *     }
 * )
 *
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
class OvertimeHistory implements EmployeeOvertimeHistoryInterface, ActionLoggerAwareInterface
{
    use ActionLoggerAwareTrait;
    use Timestampable;
    use SoftDeletable;

    /**
     * @Groups({"read"})
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid")
     *
     * @var string
     */
    private $id;

    /**
     * @Groups({"read"})
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\Employee", fetch="EAGER")
     * @ORM\JoinColumn(name="employee_id", referencedColumnName="id")
     *
     * @var EmployeeInterface
     */
    private $employee;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $overtimeYear;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $overtimeMonth;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="float", scale=27, precision=2)
     *
     * @var float
     */
    private $calculatedValue;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    private $closed;

    public function __construct()
    {
        $this->closed = true;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return EmployeeInterface
     */
    public function getEmployee(): EmployeeInterface
    {
        return $this->employee;
    }

    /**
     * @param EmployeeInterface $employee
     */
    public function setEmployee(EmployeeInterface $employee = null): void
    {
        $this->employee = $employee;
    }

    /**
     * @return int
     */
    public function getOvertimeYear(): int
    {
        return $this->overtimeYear;
    }

    /**
     * @param int $year
     */
    public function setOvertimeYear(int $year): void
    {
        $this->overtimeYear = $year;
    }

    /**
     * @return int
     */
    public function getOvertimeMonth(): int
    {
        return $this->overtimeMonth;
    }

    /**
     * @param int $month
     */
    public function setOvertimeMonth(int $month): void
    {
        $this->overtimeMonth = $month;
    }

    /**
     * @return float
     */
    public function getCalculatedValue(): float
    {
        return $this->calculatedValue;
    }

    /**
     * @param float $calculatedValue
     */
    public function setCalculatedValue(float $calculatedValue): void
    {
        $this->calculatedValue = $calculatedValue;
    }

    /**
     * @return bool
     */
    public function isClosed(): bool
    {
        return $this->closed;
    }

    /**
     * @param bool $closed
     */
    public function setClosed(bool $closed): void
    {
        $this->closed = $closed;
    }
}
