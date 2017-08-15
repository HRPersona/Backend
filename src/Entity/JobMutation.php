<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Allocation\Model\MutationInterface;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Core\Logger\Model\ActionLoggerAwareInterface;
use Persona\Hris\Employee\Model\EmployeeAwareInterface;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Organization\Model\CompanyInterface;
use Persona\Hris\Organization\Model\DepartmentInterface;
use Persona\Hris\Organization\Model\JobTitleInterface;
use Persona\Hris\Organization\Model\NewCompanyAwareInterface;
use Persona\Hris\Organization\Model\NewDepartmentAwareInterface;
use Persona\Hris\Organization\Model\NewJobTitleAwareInterface;
use Persona\Hris\Organization\Model\OldCompanyAwareInterface;
use Persona\Hris\Organization\Model\OldDepartmentAwareInterface;
use Persona\Hris\Organization\Model\OldJobTitleAwareInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="ja_mutations", indexes={
 *     @ORM\Index(name="mutation_search_old", columns={"employee_id", "old_jobtitle_id", "old_company_id", "old_department_id"}),
 *     @ORM\Index(name="mutation_search_new", columns={"employee_id", "new_jobtitle_id", "new_company_id", "new_department_id"}),
 *     @ORM\Index(name="mutation_search_employee_id", columns={"employee_id"}),
 *     @ORM\Index(name="mutation_search_old_jobtitle", columns={"old_jobtitle_id"}),
 *     @ORM\Index(name="mutation_search_old_company", columns={"old_company_id"}),
 *     @ORM\Index(name="mutation_search_old_department", columns={"old_department_id"}),
 *     @ORM\Index(name="mutation_search_new_jobtitle", columns={"new_jobtitle_id"}),
 *     @ORM\Index(name="mutation_search_new_company", columns={"new_company_id"}),
 *     @ORM\Index(name="mutation_search_new_department", columns={"new_department_id"})
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
class JobMutation implements MutationInterface, EmployeeAwareInterface, OldJobTitleAwareInterface, OldCompanyAwareInterface, OldDepartmentAwareInterface, NewJobTitleAwareInterface, NewCompanyAwareInterface, NewDepartmentAwareInterface, ActionLoggerAwareInterface
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
     * @ORM\Column(type="string", name="old_jobtitle_id", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $oldJobTitleId;

    /**
     * @var JobTitleInterface
     */
    private $oldJobTitle;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $oldCompanyId;

    /**
     * @var CompanyInterface
     */
    private $oldCompany;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $oldDepartmentId;

    /**
     * @var DepartmentInterface
     */
    private $oldDepartment;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", name="new_jobtitle_id", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $newJobTitleId;

    /**
     * @var JobTitleInterface
     */
    private $newJobTitle;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $newCompanyId;

    /**
     * @var CompanyInterface
     */
    private $newCompany;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $newDepartmentId;

    /**
     * @var DepartmentInterface
     */
    private $newDepartment;

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
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $letterNumber;

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
    public function getEmployee(): ? EmployeeInterface
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
    public function getOldJobTitleId(): string
    {
        return (string) $this->oldJobTitleId;
    }

    /**
     * @param string $oldJobTitleId
     */
    public function setOldJobTitleId(string $oldJobTitleId = null)
    {
        $this->oldJobTitleId = $oldJobTitleId;
    }

    /**
     * @return JobTitleInterface
     */
    public function getOldJobTitle(): ? JobTitleInterface
    {
        return $this->oldJobTitle;
    }

    /**
     * @param JobTitleInterface $oldJobTitle
     */
    public function setOldJobTitle(JobTitleInterface $oldJobTitle = null): void
    {
        $this->oldJobTitle = $oldJobTitle;
        if ($oldJobTitle) {
            $this->oldJobTitleId = $oldJobTitle->getId();
        }
    }

    /**
     * @return string
     */
    public function getOldCompanyId(): string
    {
        return (string) $this->oldCompanyId;
    }

    /**
     * @param string $oldCompanyId
     */
    public function setOldCompanyId(string $oldCompanyId = null)
    {
        $this->oldCompanyId = $oldCompanyId;
    }

    /**
     * @return CompanyInterface
     */
    public function getOldCompany(): ? CompanyInterface
    {
        return $this->oldCompany;
    }

    /**
     * @param CompanyInterface $oldCompany
     */
    public function setOldCompany(CompanyInterface $oldCompany = null): void
    {
        $this->oldCompany = $oldCompany;
        if ($oldCompany) {
            $this->oldCompanyId = $oldCompany->getId();
        }
    }

    /**
     * @return string
     */
    public function getOldDepartmentId(): string
    {
        return (string) $this->oldDepartmentId;
    }

    /**
     * @param string $oldDepartmentId
     */
    public function setOldDepartmentId(string $oldDepartmentId = null)
    {
        $this->oldDepartmentId = $oldDepartmentId;
    }

    /**
     * @return DepartmentInterface
     */
    public function getOldDepartment(): ? DepartmentInterface
    {
        return $this->oldDepartment;
    }

    /**
     * @param DepartmentInterface $oldDepartment
     */
    public function setOldDepartment(DepartmentInterface $oldDepartment = null): void
    {
        $this->oldDepartment = $oldDepartment;
        if ($oldDepartment) {
            $this->oldDepartmentId = $oldDepartment->getId();
        }
    }

    /**
     * @return string
     */
    public function getNewJobTitleId(): string
    {
        return (string) $this->newJobTitleId;
    }

    /**
     * @param string $newJobTitleId
     */
    public function setNewJobTitleId(string $newJobTitleId = null)
    {
        $this->newJobTitleId = $newJobTitleId;
    }

    /**
     * @return JobTitleInterface
     */
    public function getNewJobTitle(): ? JobTitleInterface
    {
        return $this->newJobTitle;
    }

    /**
     * @param JobTitleInterface $newJobTitle
     */
    public function setNewJobTitle(JobTitleInterface $newJobTitle = null): void
    {
        $this->newJobTitle = $newJobTitle;
        if ($newJobTitle) {
            $this->newJobTitleId = $newJobTitle->getId();
        }
    }

    /**
     * @return string
     */
    public function getNewCompanyId(): string
    {
        return (string) $this->newCompanyId;
    }

    /**
     * @param string $newCompanyId
     */
    public function setNewCompanyId(string $newCompanyId = null)
    {
        $this->newCompanyId = $newCompanyId;
    }

    /**
     * @return CompanyInterface
     */
    public function getNewCompany(): ? CompanyInterface
    {
        return $this->newCompany;
    }

    /**
     * @param CompanyInterface $newCompany
     */
    public function setNewCompany(CompanyInterface $newCompany = null): void
    {
        $this->newCompany = $newCompany;
        if ($newCompany) {
            $this->newCompanyId = $newCompany->getId();
        }
    }

    /**
     * @return string
     */
    public function getNewDepartmentId(): string
    {
        return (string) $this->newDepartmentId;
    }

    /**
     * @param string $newDepartmentId
     */
    public function setNewDepartmentId(string $newDepartmentId = null)
    {
        $this->newDepartmentId = $newDepartmentId;
    }

    /**
     * @return DepartmentInterface
     */
    public function getNewDepartment(): ? DepartmentInterface
    {
        return $this->newDepartment;
    }

    /**
     * @param DepartmentInterface $newDepartment
     */
    public function setNewDepartment(DepartmentInterface $newDepartment = null): void
    {
        $this->newDepartment = $newDepartment;
        if ($newDepartment) {
            $this->newDepartmentId = $newDepartment->getId();
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
}
