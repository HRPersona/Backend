<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Core\Logger\Model\ActionLoggerAwareInterface;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Organization\Model\CompanyAwareInterface;
use Persona\Hris\Organization\Model\CompanyInterface;
use Persona\Hris\Organization\Model\DepartmentAwareInterface;
use Persona\Hris\Organization\Model\DepartmentInterface;
use Persona\Hris\Organization\Model\JobClassAwareInterface;
use Persona\Hris\Organization\Model\JobClassInterface;
use Persona\Hris\Organization\Model\JobTitleAwareInterface;
use Persona\Hris\Organization\Model\JobTitleInterface;
use Persona\Hris\Share\Model\CityAwareInterface;
use Persona\Hris\Share\Model\CityInterface;
use Persona\Hris\Share\Model\PlaceOfBirthAwareInterface;
use Persona\Hris\Share\Model\ProvinceAwareInterface;
use Persona\Hris\Share\Model\ProvinceInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="em_employees", indexes={
 *     @ORM\Index(name="employee_search_idx", columns={"code", "email", "tax_number", "phone_number"}),
 *     @ORM\Index(name="employee_search_idx_relation", columns={"company_id", "department_id", "job_title_id", "birth_city_id"}),
 *     @ORM\Index(name="employee_search_idx_code", columns={"code"}),
 *     @ORM\Index(name="employee_search_idx_company", columns={"company_id"}),
 *     @ORM\Index(name="employee_search_idx_department", columns={"department_id"}),
 *     @ORM\Index(name="employee_search_idx_job_title", columns={"job_title_id"}),
 *     @ORM\Index(name="employee_search_idx_birth_city", columns={"birth_city_id"}),
 *     @ORM\Index(name="employee_search_idx_city", columns={"city_id"}),
 *     @ORM\Index(name="employee_search_idx_province", columns={"province_id"}),
 *     @ORM\Index(name="employee_search_idx_email", columns={"email"}),
 *     @ORM\Index(name="employee_search_idx_tax_number", columns={"tax_number"}),
 *     @ORM\Index(name="employee_search_idx_phone_number", columns={"phone_number"})
 * })
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
class Employee implements EmployeeInterface, ProvinceAwareInterface, CityAwareInterface, PlaceOfBirthAwareInterface, JobTitleAwareInterface, JobClassAwareInterface, CompanyAwareInterface, DepartmentAwareInterface, ActionLoggerAwareInterface
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
    private $jobClassId;

    /**
     * @var JobClassInterface
     */
    private $jobClass;

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
     * @ORM\Column(type="string", name="birth_city_id", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $placeOfBirthId;

    /**
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
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $cityId;

    /**
     * @var CityInterface
     */
    private $city;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $provinceId;

    /**
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
     * @Groups({"read"})
     * @ORM\Column(type="float", scale=27, precision=2)
     * @Assert\NotBlank()
     *
     * @var float
     */
    private $basicSalary;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     *
     * @var int
     */
    private $leaveBalance;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="boolean")
     * @Assert\NotBlank()
     *
     * @var bool
     */
    private $resign;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     *
     * @var \DateTime
     */
    private $resignDate;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
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
    public function getJobClassId(): string
    {
        return (string) $this->jobClassId;
    }

    /**
     * @param string $jobClassId
     */
    public function setJobClassId(string $jobClassId = null)
    {
        $this->jobClassId = $jobClassId;
    }

    /**
     * @return JobClassInterface
     */
    public function getJobClass(): ? JobClassInterface
    {
        return $this->jobClass;
    }

    /**
     * @param JobClassInterface $jobClass
     */
    public function setJobClass(JobClassInterface $jobClass = null): void
    {
        $this->jobClass = $jobClass;
        if ($jobClass) {
            $this->jobClassId = $jobClass->getId();
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
    public function getCompany(): ? CompanyInterface
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
    public function getDepartment(): ? DepartmentInterface
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
     * @return string
     */
    public function getPlaceOfBirthId(): string
    {
        return (string) $this->placeOfBirthId;
    }

    /**
     * @param string $placeOfBirthId
     */
    public function setPlaceOfBirthId(string $placeOfBirthId = null)
    {
        $this->placeOfBirthId = $placeOfBirthId;
    }

    /**
     * @return CityInterface
     */
    public function getPlaceOfBirth(): ? CityInterface
    {
        return $this->placeOfBirth;
    }

    /**
     * @param CityInterface $placeOfBirth
     */
    public function setPlaceOfBirth(CityInterface $placeOfBirth = null): void
    {
        $this->placeOfBirth = $placeOfBirth;
        if ($placeOfBirth) {
            $this->placeOfBirthId = $placeOfBirth->getId();
        }
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
     * @return string
     */
    public function getCityId(): string
    {
        return (string) $this->cityId;
    }

    /**
     * @param string $cityId
     */
    public function setCityId(string $cityId = null)
    {
        $this->cityId = $cityId;
    }

    /**
     * @return CityInterface
     */
    public function getCity(): ? CityInterface
    {
        return $this->city;
    }

    /**
     * @param CityInterface $city
     */
    public function setCity(CityInterface $city = null): void
    {
        $this->city = $city;
        if ($city) {
            $this->cityId = $city->getId();
        }
    }

    /**
     * @return string
     */
    public function getProvinceId(): string
    {
        return (string) $this->provinceId;
    }

    /**
     * @param string $provinceId
     */
    public function setProvinceId(string $provinceId = null)
    {
        $this->provinceId = $provinceId;
    }

    /**
     * @return ProvinceInterface
     */
    public function getProvince(): ? ProvinceInterface
    {
        return $this->province;
    }

    /**
     * @param ProvinceInterface $province
     */
    public function setProvince(ProvinceInterface $province = null): void
    {
        $this->province = $province;
        if ($province) {
            $this->provinceId = $province->getId();
        }
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
        if (!$this->getResignDate()) {
            return false;
        }

        $lastDayOfMonth = \DateTime::createFromFormat('Y-m-d', date('Y-m-t'));
        $resignDateString = sprintf(
            '%s-%s-%s %s:%s:%s',
            $this->getResignDate()->format('Y'),
            $this->getResignDate()->format('m'),
            $this->getResignDate()->format('d'),
            $lastDayOfMonth->format('H'),
            $lastDayOfMonth->format('i'),
            $lastDayOfMonth->format('s')
        );

        $resignDate = \DateTime::createFromFormat('Y-m-d H:i:s', $resignDateString);
        if ($resignDate > $lastDayOfMonth && $this->resign) {
            return true;
        }

        return false;
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
    public function getResignDate(): ? \DateTime
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
