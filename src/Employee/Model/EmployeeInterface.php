<?php

namespace Persona\Hris\Employee\Model;

use Persona\Hris\Organization\Model\CompanyInterface;
use Persona\Hris\Organization\Model\DepartmentInterface;
use Persona\Hris\Organization\Model\JobClassInterface;
use Persona\Hris\Organization\Model\JobTitleInterface;
use Persona\Hris\Share\Model\CityInterface;
use Persona\Hris\Share\Model\ProvinceInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface EmployeeInterface
{
    const IDENTITY_DRIVER_LISENCE = 's';
    const IDENTITY_PASSPORT = 'p';
    const IDENTITY_ID_CARD = 'k';

    const MARITAL_SINGLE = 's';
    const MARITAL_MARRIED = 'm';
    const MARITAL_DISVORCE = 'd';

    const STATUS_CONTRACT = 'c';
    const STATUS_INTERSHIP = 'i';
    const STATUS_PERMANENT = 'p';
    const STATUS_OUTSOURCE = 'o';

    const TAX_TK_0 = 'tk0';
    const TAX_TK_1 = 'tk1';
    const TAX_TK_2 = 'tk2';
    const TAX_TK_3 = 'tk3';
    const TAX_K_0 = 'k0';
    const TAX_K_1 = 'k1';
    const TAX_K_2 = 'k2';
    const TAX_K_3 = 'k3';
    const TAX_KI_0 = 'ki0';
    const TAX_KI_1 = 'ki1';
    const TAX_KI_2 = 'ki2';
    const TAX_KI_3 = 'ki3';

    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return \DateTime
     */
    public function getJoinDate(): \DateTime;

    /**
     * @return string
     */
    public function getEmployeeStatus(): string;

    /**
     * @return string
     */
    public function getLetterNumber(): ? string;

    /**
     * @param string $letterNumber
     */
    public function setLetterNumber(string $letterNumber): void;

    /**
     * @return \DateTime
     */
    public function getContractEndDate(): ? \DateTime;

    /**
     * @param \DateTime $dateTime
     */
    public function setContractEndDate(\DateTime $dateTime): void;

    /**
     * @return null|JobTitleInterface
     */
    public function getJobTitle(): ? JobTitleInterface;

    /**
     * @param JobTitleInterface $jobTitle
     */
    public function setJobTitle(JobTitleInterface $jobTitle = null): void;

    /**
     * @return null|JobClassInterface
     */
    public function getJobClass(): ? JobClassInterface;

    /**
     * @param JobClassInterface $class
     */
    public function setJobClass(JobClassInterface $class = null): void;

    /**
     * @return null|CompanyInterface
     */
    public function getCompany(): ? CompanyInterface;

    /**
     * @param CompanyInterface $company
     */
    public function setCompany(CompanyInterface $company = null): void;

    /**
     * @return null|DepartmentInterface
     */
    public function getDepartment(): ? DepartmentInterface;

    /**
     * @param DepartmentInterface $department
     */
    public function setDepartment(DepartmentInterface $department = null): void;

    /**
     * @return string
     */
    public function getCode(): string;

    /**
     * @return string
     */
    public function getFullName(): string;

    /**
     * @return null|CityInterface
     */
    public function getPlaceOfBirth(): ? CityInterface;

    /**
     * @param CityInterface $city
     */
    public function setPlaceOfBirth(CityInterface $city = null): void;

    /**
     * @return \DateTime
     */
    public function getDateOfBirth(): \DateTime;

    /**
     * @return string
     */
    public function getIdentityNumber(): string;

    /**
     * @return string
     */
    public function getIdentityType(): string;

    /**
     * @return string
     */
    public function getMaritalStatus(): string;

    /**
     * @return string
     */
    public function getAddress(): string;

    /**
     * @return null|CityInterface
     */
    public function getCity(): ? CityInterface;

    /**
     * @param CityInterface $city
     */
    public function setCity(CityInterface $city = null): void;

    /**
     * @return null|ProvinceInterface
     */
    public function getProvince(): ? ProvinceInterface;

    /**
     * @param ProvinceInterface $province
     */
    public function setProvince(ProvinceInterface $province = null): void;

    /**
     * @return string
     */
    public function getPhoneNumber(): string;

    /**
     * @return string
     */
    public function getTaxNumber(): string;

    /**
     * @return string
     */
    public function getEmail(): string;

    /**
     * @return bool
     */
    public function isHaveOvertimeBenefit(): bool;

    /**
     * @param bool $haveOvertimeBenefit
     */
    public function setHaveOvertimeBenefit(bool $haveOvertimeBenefit): void;

    /**
     * @return float
     */
    public function getBasicSalary(): float;

    /**
     * @param float $basicSalary
     */
    public function setBasicSalary(float $basicSalary): void;

    /**
     * @return int
     */
    public function getLeaveBalance(): int;

    /**
     * @param int $leaveBalance
     */
    public function setLeaveBalance(int $leaveBalance): void;

    /**
     * @return bool
     */
    public function isResign(): bool;

    /**
     * @param bool $resign
     */
    public function setResign(bool $resign): void;

    /**
     * @return \DateTime|null
     */
    public function getResignDate(): ? \DateTime;

    /**
     * @param \DateTime $dateTime
     */
    public function setResignDate(\DateTime $dateTime): void;

    /**
     * @return string
     */
    public function getTaxGroup(): string;
}
