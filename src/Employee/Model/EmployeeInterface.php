<?php

namespace Persona\Hris\Employee\Model;

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

    const STATUS_CONTRACT = 'c';
    const STATUS_INTERSHIP = 'i';
    const STATUS_PERMANENT = 'p';
    const STATUS_OUTSOURCE = 'o';

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
    public function getStatus(): string;

    /**
     * @return string
     */
    public function getLetterNumber():? string;

    /**
     * @return \DateTime
     */
    public function getContractEndDate():? \DateTime;

    /**
     * @return null|JobTitleInterface
     */
    public function getJobTitle():? JobTitleInterface;

    /**
     * @param JobTitleInterface $jobTitle
     */
    public function setJobTitle(JobTitleInterface $jobTitle): void;

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
    public function getPlaceOfBirth():? CityInterface;

    /**
     * @param CityInterface $city
     */
    public function setPlaceOfBirth(CityInterface $city): void;

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
    public function getCity():? CityInterface;

    /**
     * @param CityInterface $city
     */
    public function setCity(CityInterface $city): void;

    /**
     * @return null|ProvinceInterface
     */
    public function getProvince():? ProvinceInterface;

    /**
     * @param ProvinceInterface $province
     */
    public function setProvince(ProvinceInterface $province): void;

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
}
