<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Core\Logger\Model\ActionLoggerAwareInterface;
use Persona\Hris\Employee\Model\EmployeeAwareInterface;
use Persona\Hris\Employee\Model\EmployeeFamilyInterface;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Share\Model\CityInterface;
use Persona\Hris\Share\Model\EducationTitleAwareInterface;
use Persona\Hris\Share\Model\EducationTitleInterface;
use Persona\Hris\Share\Model\PlaceOfBirthAwareInterface;
use Persona\Hris\Share\Model\UniversityAwareInterface;
use Persona\Hris\Share\Model\UniversityInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="em_employee_families", indexes={
 *     @ORM\Index(name="employee_education_search_idx", columns={"employee_id", "birth_city_id", "university_id", "education_title_id"}),
 *     @ORM\Index(name="employee_education_search_employee_id", columns={"employee_id"}),
 *     @ORM\Index(name="employee_education_search_birth_city", columns={"birth_city_id"}),
 *     @ORM\Index(name="employee_education_search_university", columns={"university_id"}),
 *     @ORM\Index(name="employee_education_search_education_title", columns={"education_title_id"})
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
class EmployeeFamily implements EmployeeFamilyInterface, EmployeeAwareInterface, PlaceOfBirthAwareInterface, UniversityAwareInterface, EducationTitleAwareInterface, ActionLoggerAwareInterface
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
     * @ORM\Column(type="string", length=1)
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="1")
     *
     * @var string
     */
    private $relationship;

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
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    private $universityId;

    /**
     * @var UniversityInterface
     */
    private $university;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    private $educationTitleId;

    /**
     * @var EducationTitleInterface
     */
    private $educationTitle;

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
        if ($employee) {
            $this->employeeId = $employee->getId();
        }
    }

    /**
     * @return string
     */
    public function getRelationship(): string
    {
        return $this->relationship;
    }

    /**
     * @param string $relationship
     */
    public function setRelationship(string $relationship)
    {
        if (!in_array($relationship, [EmployeeFamilyInterface::RELATION_COUPLE, EmployeeFamilyInterface::RELATION_PARENT, EmployeeFamilyInterface::RELATION_SON])) {
            throw new \InvalidArgumentException(sprintf('%s is not valid relationship', $relationship));
        }

        $this->relationship = $relationship;
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
    public function setFullName(string $fullName)
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
     * @return CityInterface|null
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
    public function setDateOfBirth(\DateTime $dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    /**
     * @return string
     */
    public function getUniversityId(): string
    {
        return (string) $this->universityId;
    }

    /**
     * @param string $universityId
     */
    public function setUniversityId(string $universityId = null)
    {
        $this->universityId = $universityId;
    }

    /**
     * @return UniversityInterface
     */
    public function getUniversity(): ? UniversityInterface
    {
        return $this->university;
    }

    /**
     * @param UniversityInterface $university
     */
    public function setUniversity(UniversityInterface $university = null): void
    {
        $this->university = $university;
        if ($university) {
            $this->universityId = $university->getId();
        }
    }

    /**
     * @return string
     */
    public function getEducationTitleId(): string
    {
        return (string) $this->educationTitleId;
    }

    /**
     * @param string $educationTitleId
     */
    public function setEducationTitleId(string $educationTitleId = null)
    {
        $this->educationTitleId = $educationTitleId;
    }

    /**
     * @return EducationTitleInterface|null
     */
    public function getEducationTitle(): ? EducationTitleInterface
    {
        return $this->educationTitle;
    }

    /**
     * @param EducationTitleInterface $educationTitle
     */
    public function setEducationTitle(EducationTitleInterface $educationTitle = null): void
    {
        $this->educationTitle = $educationTitle;
        if ($educationTitle) {
            $this->educationTitleId = $educationTitle->getId();
        }
    }
}
