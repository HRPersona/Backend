<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Core\Logger\ActionLoggerAwareInterface;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Organization\Model\CompanyInterface;
use Persona\Hris\Organization\Model\DepartmentInterface;
use Persona\Hris\Organization\Model\JobTitleInterface;
use Persona\Hris\Share\Model\CityInterface;
use Persona\Hris\Share\Model\ProvinceInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="em_employees", indexes={@ORM\Index(name="employee_search_idx", columns={"code", "email", "tax_number", "phone_number"})})
 *
 * @ApiResource(
 *     attributes={
 *         "filters"={
 *             "order.filter",
 *             "code.search",
 *             "name.search",
 *             "email.search"
 *         },
 *         "normalization_context"={"groups"={"read"}},
 *         "denormalization_context"={"groups"={"write"}}
 *     }
 * )
 *
 * @UniqueEntity("code")
 * @UniqueEntity("email")
 * @UniqueEntity("taxNumber")
 * @UniqueEntity("phoneNumber")
 *
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
class Employee implements EmployeeInterface, ActionLoggerAwareInterface
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
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     *
     * @var \DateTime
     */
    private $joinDate;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=1)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $employeeStatus;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=27)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $letterNumber;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     *
     * @var \DateTime
     */
    private $contractEndDate;

    /**
     * @Groups({"read", "write"})
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\JobTitle", fetch="EAGER")
     * @ORM\JoinColumn(name="jobtitle_id", referencedColumnName="id")
     * @Assert\NotBlank()
     *
     * @var JobTitleInterface
     */
    private $jobTitle;

    /**
     * @Groups({"read", "write"})
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\Company", fetch="EAGER")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     * @Assert\NotBlank()
     *
     * @var CompanyInterface
     */
    private $company;

    /**
     * @Groups({"read", "write"})
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\Department", fetch="EAGER")
     * @ORM\JoinColumn(name="department_id", referencedColumnName="id")
     * @Assert\NotBlank()
     *
     * @var DepartmentInterface
     */
    private $department;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=17)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $code;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $fullName;

    /**
     * @Groups({"read", "write"})
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\City", fetch="EAGER")
     * @ORM\JoinColumn(name="birth_city_id", referencedColumnName="id")
     * @Assert\NotBlank()
     *
     * @var CityInterface
     */
    private $placeOfBirth;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     *
     * @var \DateTime
     */
    private $dateOfBirth;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=27)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $identityNumber;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $identityType;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=1)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $maritalStatus;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $address;

    /**
     * @Groups({"read", "write"})
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\City", fetch="EAGER")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     * @Assert\NotBlank()
     *
     * @var CityInterface
     */
    private $city;

    /**
     * @Groups({"read", "write"})
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\Province", fetch="EAGER")
     * @ORM\JoinColumn(name="province_id", referencedColumnName="id")
     * @Assert\NotBlank()
     *
     * @var ProvinceInterface
     */
    private $province;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=17)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $phoneNumber;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=27)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $taxNumber;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $email;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="boolean")
     * @Assert\NotBlank()
     *
     * @var bool
     */
    private $haveOvertimeBenefit;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="float", scale=27, precision=2)
     * @Assert\NotBlank()
     *
     * @var float
     */
    private $basicSalary;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     *
     * @var int
     */
    private $leaveBalance;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="boolean")
     * @Assert\NotBlank()
     *
     * @var bool
     */
    private $resign;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     *
     * @var \DateTime
     */
    private $resignDate;

    /**
     * @var string
     */
    private $taxGroup;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getJoinDate(): \DateTime
    {
        return $this->joinDate;
    }

    /**
     * @param \DateTime $joinDate
     */
    public function setJoinDate(\DateTime $joinDate): void
    {
        $this->joinDate = $joinDate;
    }

    /**
     * @return string
     */
    public function getEmployeeStatus(): string
    {
        return $this->employeeStatus;
    }

    /**
     * @param string $employeeStatus
     */
    public function setEmployeeStatus(string $employeeStatus): void
    {
        $this->employeeStatus = $employeeStatus;
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
    public function setLetterNumber(string $letterNumber): void
    {
        $this->letterNumber = $letterNumber;
    }

    /**
     * @return \DateTime
     */
    public function getContractEndDate(): \DateTime
    {
        return $this->contractEndDate;
    }

    /**
     * @param \DateTime $contractEndDate
     */
    public function setContractEndDate(\DateTime $contractEndDate): void
    {
        $this->contractEndDate = $contractEndDate;
    }

    /**
     * @return JobTitleInterface
     */
    public function getJobTitle(): JobTitleInterface
    {
        return $this->jobTitle;
    }

    /**
     * @param JobTitleInterface $jobTitle
     */
    public function setJobTitle(JobTitleInterface $jobTitle = null): void
    {
        $this->jobTitle = $jobTitle;
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
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->fullName;
    }

    /**
     * @param string $fullName
     */
    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
    }

    /**
     * @return CityInterface
     */
    public function getPlaceOfBirth(): CityInterface
    {
        return $this->placeOfBirth;
    }

    /**
     * @param CityInterface $placeOfBirth
     */
    public function setPlaceOfBirth(CityInterface $placeOfBirth = null): void
    {
        $this->placeOfBirth = $placeOfBirth;
    }

    /**
     * @return \DateTime
     */
    public function getDateOfBirth(): \DateTime
    {
        return $this->dateOfBirth;
    }

    /**
     * @param \DateTime $dateOfBirth
     */
    public function setDateOfBirth(\DateTime $dateOfBirth): void
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    /**
     * @return string
     */
    public function getIdentityNumber(): string
    {
        return $this->identityNumber;
    }

    /**
     * @param string $identityNumber
     */
    public function setIdentityNumber(string $identityNumber): void
    {
        $this->identityNumber = $identityNumber;
    }

    /**
     * @return string
     */
    public function getIdentityType(): string
    {
        return $this->identityType;
    }

    /**
     * @param string $identityType
     */
    public function setIdentityType(string $identityType): void
    {
        $this->identityType = $identityType;
    }

    /**
     * @return string
     */
    public function getMaritalStatus(): string
    {
        return $this->maritalStatus;
    }

    /**
     * @param string $maritalStatus
     */
    public function setMaritalStatus(string $maritalStatus): void
    {
        $this->maritalStatus = $maritalStatus;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return CityInterface
     */
    public function getCity(): CityInterface
    {
        return $this->city;
    }

    /**
     * @param CityInterface $city
     */
    public function setCity(CityInterface $city = null): void
    {
        $this->city = $city;
    }

    /**
     * @return ProvinceInterface
     */
    public function getProvince(): ProvinceInterface
    {
        return $this->province;
    }

    /**
     * @param ProvinceInterface $province
     */
    public function setProvince(ProvinceInterface $province = null): void
    {
        $this->province = $province;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string
     */
    public function getTaxNumber(): string
    {
        return $this->taxNumber;
    }

    /**
     * @param string $taxNumber
     */
    public function setTaxNumber(string $taxNumber): void
    {
        $this->taxNumber = $taxNumber;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return bool
     */
    public function isHaveOvertimeBenefit(): bool
    {
        return $this->haveOvertimeBenefit;
    }

    /**
     * @param bool $haveOvertimeBenefit
     */
    public function setHaveOvertimeBenefit(bool $haveOvertimeBenefit): void
    {
        $this->haveOvertimeBenefit = $haveOvertimeBenefit;
    }

    /**
     * @return float
     */
    public function getBasicSalary(): float
    {
        return $this->basicSalary;
    }

    /**
     * @param float $basicSalary
     */
    public function setBasicSalary(float $basicSalary): void
    {
        $this->basicSalary = $basicSalary;
    }

    /**
     * @return int
     */
    public function getLeaveBalance(): int
    {
        return $this->leaveBalance;
    }

    /**
     * @param int $leaveBalance
     */
    public function setLeaveBalance(int $leaveBalance): void
    {
        $this->leaveBalance = $leaveBalance;
    }

    /**
     * @return bool
     */
    public function isResign(): bool
    {
        return $this->resign;
    }

    /**
     * @param bool $resign
     */
    public function setResign(bool $resign): void
    {
        $this->resign = $resign;
    }

    /**
     * @return \DateTime
     */
    public function getResignDate(): \DateTime
    {
        return $this->resignDate;
    }

    /**
     * @param \DateTime $resignDate
     */
    public function setResignDate(\DateTime $resignDate): void
    {
        $this->resignDate = $resignDate;
    }

    /**
     * @return string
     */
    public function getTaxGroup(): string
    {
        return $this->taxGroup;
    }

    /**
     * @param string $taxGroup
     */
    public function setTaxGroup(string $taxGroup): void
    {
        $this->taxGroup = $taxGroup;
    }
}
