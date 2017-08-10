<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Allocation\Model\MutationInterface;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Core\Logger\Model\ActionLoggerAwareInterface;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Organization\Model\CompanyInterface;
use Persona\Hris\Organization\Model\DepartmentInterface;
use Persona\Hris\Organization\Model\JobTitleInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="ja_mutations")
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
class JobMutation implements MutationInterface, ActionLoggerAwareInterface
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
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\Employee", fetch="EAGER")
     * @ORM\JoinColumn(name="employee_id", referencedColumnName="id")
     * @Assert\NotBlank()
     *
     * @var EmployeeInterface
     */
    private $employee;

    /**
     * @Groups({"read", "write"})
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\JobTitle", fetch="EAGER")
     * @ORM\JoinColumn(name="old_jobtitle_id", referencedColumnName="id")
     * @Assert\NotBlank()
     *
     * @var JobTitleInterface
     */
    private $oldJobTitle;

    /**
     * @Groups({"read", "write"})
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\Company", fetch="EAGER")
     * @ORM\JoinColumn(name="old_company_id", referencedColumnName="id")
     * @Assert\NotBlank()
     *
     * @var CompanyInterface
     */
    private $oldCompany;

    /**
     * @Groups({"read", "write"})
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\Department", fetch="EAGER")
     * @ORM\JoinColumn(name="old_department_id", referencedColumnName="id")
     * @Assert\NotBlank()
     *
     * @var DepartmentInterface
     */
    private $oldDepartment;

    /**
     * @Groups({"read", "write"})
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\JobTitle", fetch="EAGER")
     * @ORM\JoinColumn(name="new_jobtitle_id", referencedColumnName="id")
     * @Assert\NotBlank()
     *
     * @var JobTitleInterface
     */
    private $newJobTitle;

    /**
     * @Groups({"read", "write"})
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\Company", fetch="EAGER")
     * @ORM\JoinColumn(name="new_company_id", referencedColumnName="id")
     * @Assert\NotBlank()
     *
     * @var CompanyInterface
     */
    private $newCompany;

    /**
     * @Groups({"read", "write"})
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\Department", fetch="EAGER")
     * @ORM\JoinColumn(name="new_department_id", referencedColumnName="id")
     * @Assert\NotBlank()
     *
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
     * @return JobTitleInterface
     */
    public function getOldJobTitle(): JobTitleInterface
    {
        return $this->oldJobTitle;
    }

    /**
     * @param JobTitleInterface $oldJobTitle
     */
    public function setOldJobTitle(JobTitleInterface $oldJobTitle = null): void
    {
        $this->oldJobTitle = $oldJobTitle;
    }

    /**
     * @return CompanyInterface
     */
    public function getOldCompany(): CompanyInterface
    {
        return $this->oldCompany;
    }

    /**
     * @param CompanyInterface $oldCompany
     */
    public function setOldCompany(CompanyInterface $oldCompany = null): void
    {
        $this->oldCompany = $oldCompany;
    }

    /**
     * @return DepartmentInterface
     */
    public function getOldDepartment(): DepartmentInterface
    {
        return $this->oldDepartment;
    }

    /**
     * @param DepartmentInterface $oldDepartment
     */
    public function setOldDepartment(DepartmentInterface $oldDepartment = null): void
    {
        $this->oldDepartment = $oldDepartment;
    }

    /**
     * @return JobTitleInterface
     */
    public function getNewJobTitle(): JobTitleInterface
    {
        return $this->newJobTitle;
    }

    /**
     * @param JobTitleInterface $newJobTitle
     */
    public function setNewJobTitle(JobTitleInterface $newJobTitle = null): void
    {
        $this->newJobTitle = $newJobTitle;
    }

    /**
     * @return CompanyInterface
     */
    public function getNewCompany(): CompanyInterface
    {
        return $this->newCompany;
    }

    /**
     * @param CompanyInterface $newCompany
     */
    public function setNewCompany(CompanyInterface $newCompany = null): void
    {
        $this->newCompany = $newCompany;
    }

    /**
     * @return DepartmentInterface
     */
    public function getNewDepartment(): DepartmentInterface
    {
        return $this->newDepartment;
    }

    /**
     * @param DepartmentInterface $newDepartment
     */
    public function setNewDepartment(DepartmentInterface $newDepartment = null): void
    {
        $this->newDepartment = $newDepartment;
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
