<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Core\Logger\ActionLoggerAwareInterface;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Insurance\Model\EmployeeInsuranceInterface;
use Persona\Hris\Insurance\Model\InsuranceInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity()
 * @ORM\Table(name="in_employee_insurances")
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
class EmployeeInsurance implements EmployeeInsuranceInterface, ActionLoggerAwareInterface
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
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\Insurance", fetch="EAGER")
     * @ORM\JoinColumn(name="insurance_id", referencedColumnName="id")
     *
     * @var InsuranceInterface
     */
    private $insurance;

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
     * @return InsuranceInterface
     */
    public function getInsurance(): InsuranceInterface
    {
        return $this->insurance;
    }

    /**
     * @param InsuranceInterface $insurance
     */
    public function setInsurance(InsuranceInterface $insurance = null): void
    {
        $this->insurance = $insurance;
    }
}
