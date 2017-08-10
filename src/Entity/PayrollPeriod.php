<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Core\Logger\Model\ActionLoggerAwareInterface;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Core\Util\StringUtil;
use Persona\Hris\Salary\Model\PayrollPeriodInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="sa_payroll_periods", indexes={@ORM\Index(name="payroll_period_search_idx", columns={"name"})})
 *
 * @ApiResource(
 *     attributes={
 *         "filters"={"order.filter"},
 *         "normalization_context"={"groups"={"read"}},
 *         "denormalization_context"={"groups"={"write"}}
 *     }
 * )
 *
 * @UniqueEntity("name")
 *
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
class PayrollPeriod implements PayrollPeriodInterface, ActionLoggerAwareInterface
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
     * @Groups({"read", "write"})
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $name;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="integer", length=4)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $payrollYear;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="integer", length=2)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $payrollMonth;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="boolean")
     *
     * @var bool
     */
    private $active;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = StringUtil::uppercase($name);
    }

    /**
     * @return string
     */
    public function getPayrollYear(): string
    {
        return $this->payrollYear;
    }

    /**
     * @param string $payrollYear
     */
    public function setPayrollYear(string $payrollYear)
    {
        $this->payrollYear = $payrollYear;
    }

    /**
     * @return string
     */
    public function getPayrollMonth(): string
    {
        return $this->payrollMonth;
    }

    /**
     * @param string $payrollMonth
     */
    public function setPayrollMonth(string $payrollMonth)
    {
        $this->payrollMonth = $payrollMonth;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }
}
