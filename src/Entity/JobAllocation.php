<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Allocation\Model\JobAllocationInterface;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Core\Logger\Model\ActionLoggerAwareInterface;
use Persona\Hris\Employee\Model\EmployeeAwareInterface;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Organization\Model\CompanyAwareInterface;
use Persona\Hris\Organization\Model\CompanyInterface;
use Persona\Hris\Organization\Model\DepartmentAwareInterface;
use Persona\Hris\Organization\Model\DepartmentInterface;
use Persona\Hris\Organization\Model\JobTitleAwareInterface;
use Persona\Hris\Organization\Model\JobTitleInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="ja_joballocations", indexes={
 *     @ORM\Index(name="employee_joballocation_search_idx", columns={"employee_id", "job_title_id", "company_id", "department_id"}),
 *     @ORM\Index(name="employee_joballocation_search_employee_id", columns={"employee_id"}),
 *     @ORM\Index(name="employee_joballocation_search_job_title", columns={"job_title_id"}),
 *     @ORM\Index(name="employee_joballocation_search_company", columns={"company_id"}),
 *     @ORM\Index(name="employee_joballocation_search_department", columns={"department_id"})
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
class JobAllocation implements JobAllocationInterface, EmployeeAwareInterface, JobTitleAwareInterface, CompanyAwareInterface, DepartmentAwareInterface, ActionLoggerAwareInterface
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
    private $jobTitleId;

    /**
     * @var JobTitleInterface
     */
    private $jobTitle;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $companyId;

    /**
     * @var CompanyInterface
     */
    private $company;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $departmentId;

    /**
     * @var DepartmentInterface
     */
    private $department;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     *
     * @var \DateTime
     */
    private $startDate;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     *
     * @var \DateTime
     */
    private $endDate;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $letterNumber;

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
        if ($this->employee) {
            $this->employeeId = $employee->getId();
        }
    }

    /**
     * @return string
     */
    public function getJobTitleId(): string
    {
        return (string) $this->jobTitleId;
    }

    /**
     * @param string $jobTitleId
     */
    public function setJobTitleId(string $jobTitleId = null)
    {
        $this->jobTitleId = $jobTitleId;
    }

    /**
     * @return JobTitleInterface
     */
    public function getJobTitle(): ? JobTitleInterface
    {
        return $this->jobTitle;
    }

    /**
     * @param JobTitleInterface $jobTitle
     */
    public function setJobTitle(JobTitleInterface $jobTitle = null): void
    {
        $this->jobTitle = $jobTitle;
        if ($jobTitle) {
            $this->jobTitleId = $jobTitle->getId();
        }
    }

    /**
     * @return string
     */
    public function getCompanyId(): string
    {
        return (string) $this->companyId;
    }

    /**
     * @param string $companyId
     */
    public function setCompanyId(string $companyId = null)
    {
        $this->companyId = $companyId;
    }

    /**
     * @return CompanyInterface
     */
    public function getCompany(): CompanyInterface
    {
        return $this->company;
    }

    /**
     * @param CompanyInterface $company
     */
    public function setCompany(CompanyInterface $company = null): void
    {
        $this->company = $company;
        if ($company) {
            $this->companyId = $company->getId();
        }
    }

    /**
     * @return string
     */
    public function getDepartmentId(): string
    {
        return (string) $this->departmentId;
    }

    /**
     * @param string $departmentId
     */
    public function setDepartmentId(string $departmentId = null)
    {
        $this->departmentId = $departmentId;
    }

    /**
     * @return DepartmentInterface
     */
    public function getDepartment(): DepartmentInterface
    {
        return $this->department;
    }

    /**
     * @param DepartmentInterface $department
     */
    public function setDepartment(DepartmentInterface $department = null): void
    {
        $this->department = $department;
        if ($department) {
            $this->departmentId = $department->getId();
        }
    }

    /**
     * @return \DateTime
     */
    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     */
    public function setStartDate(\DateTime $startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate(): \DateTime
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     */
    public function setEndDate(\DateTime $endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * @return string
     */
    public function getLetterNumber(): string
    {
        return $this->letterNumber;
    }

    /**
     * @param string $letterNumber
     */
    public function setLetterNumber(string $letterNumber)
    {
        $this->letterNumber = $letterNumber;
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
    public function setActive(bool $active)
    {
        $this->active = $active;
    }
}
