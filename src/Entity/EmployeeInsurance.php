<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Core\Logger\Model\ActionLoggerAwareInterface;
use Persona\Hris\Employee\Model\EmployeeAwareInterface;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Insurance\Model\EmployeeInsuranceInterface;
use Persona\Hris\Insurance\Model\InsuranceAwareInterface;
use Persona\Hris\Insurance\Model\InsuranceInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="in_employee_insurances", indexes={
 *     @ORM\Index(name="employee_education_search_idx", columns={"employee_id", "insurance_id"}),
 *     @ORM\Index(name="employee_education_search_employee", columns={"employee_id"}),
 *     @ORM\Index(name="employee_education_search_insurance", columns={"insurance_id"})
 * })
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
class EmployeeInsurance implements EmployeeInsuranceInterface, EmployeeAwareInterface, InsuranceAwareInterface, ActionLoggerAwareInterface
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
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $employeeId;

    /**
     * @var EmployeeInterface
     */
    private $employee;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $insuranceId;

    /**
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
     * @return string
     */
    public function getEmployeeId(): string
    {
        return (string) $this->employeeId;
    }

    /**
     * @param string $employeeId
     */
    public function setEmployeeId(string $employeeId = null)
    {
        $this->employeeId = $employeeId;
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
        if ($employee) {
            $this->employeeId = $employee->getId();
        }
    }

    /**
     * @return string
     */
    public function getInsuranceId(): string
    {
        return $this->insuranceId;
    }

    /**
     * @param string $insuranceId
     */
    public function setInsuranceId(string $insuranceId = null)
    {
        $this->insuranceId = $insuranceId;
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
        if ($insurance) {
            $this->insuranceId = $insurance->getId();
        }
    }
}
