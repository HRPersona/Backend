<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Core\Logger\Model\ActionLoggerAwareInterface;
use Persona\Hris\Employee\Model\EmployeeAwareInterface;
use Persona\Hris\Employee\Model\EmployeeEducationInterface;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Share\Model\EducationTitleAwareInterface;
use Persona\Hris\Share\Model\EducationTitleInterface;
use Persona\Hris\Share\Model\UniversityAwareInterface;
use Persona\Hris\Share\Model\UniversityInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="em_employee_educations", indexes={
 *     @ORM\Index(name="employee_education_search_idx", columns={"employee_id", "university_id", "education_title_id"}),
 *     @ORM\Index(name="employee_education_search_idx_employee", columns={"employee_id"}),
 *     @ORM\Index(name="employee_education_search_idx_university", columns={"university_id"}),
 *     @ORM\Index(name="employee_education_search_idx_education_title", columns={"education_title_id"})
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
class EmployeeEducation implements EmployeeEducationInterface, EmployeeAwareInterface, UniversityAwareInterface, EducationTitleAwareInterface, ActionLoggerAwareInterface
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
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     *
     * @var int
     */
    private $startYear;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     *
     * @var int
     */
    private $endYear;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
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
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $educationTitleId;

    /**
     * @var EducationTitleInterface
     */
    private $educationTitle;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="boolean")
     * @Assert\NotBlank()
     *
     * @var bool
     */
    private $graduated;

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
     * @return int
     */
    public function getStartYear(): int
    {
        return $this->startYear;
    }

    /**
     * @param int $startYear
     */
    public function setStartYear(int $startYear): void
    {
        $this->startYear = $startYear;
    }

    /**
     * @return int
     */
    public function getEndYear(): int
    {
        return $this->endYear;
    }

    /**
     * @param int $endYear
     */
    public function setEndYear(int $endYear): void
    {
        $this->endYear = $endYear;
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
     * @return EducationTitleInterface
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

    /**
     * @return bool
     */
    public function isGraduated(): bool
    {
        return $this->graduated;
    }

    /**
     * @param bool $graduated
     */
    public function setGraduated(bool $graduated): void
    {
        $this->graduated = $graduated;
    }
}
