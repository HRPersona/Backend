<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Core\Logger\Model\ActionLoggerAwareInterface;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Employee\Model\EmployeeEducationInterface;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Share\Model\EducationTitleInterface;
use Persona\Hris\Share\Model\UniversityInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="em_employee_educations")
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
class EmployeeEducation implements EmployeeEducationInterface, ActionLoggerAwareInterface
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
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\University", fetch="EAGER")
     * @ORM\JoinColumn(name="university_id", referencedColumnName="id")
     * @Assert\NotBlank()
     *
     * @var UniversityInterface
     */
    private $university;

    /**
     * @Groups({"read", "write"})
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\EducationTitle", fetch="EAGER")
     * @ORM\JoinColumn(name="education_title_id", referencedColumnName="id")
     * @Assert\NotBlank()
     *
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
     * @return UniversityInterface
     */
    public function getUniversity(): UniversityInterface
    {
        return $this->university;
    }

    /**
     * @param UniversityInterface $university
     */
    public function setUniversity(UniversityInterface $university = null): void
    {
        $this->university = $university;
    }

    /**
     * @return EducationTitleInterface
     */
    public function getEducationTitle(): EducationTitleInterface
    {
        return $this->educationTitle;
    }

    /**
     * @param EducationTitleInterface $educationTitle
     */
    public function setEducationTitle(EducationTitleInterface $educationTitle = null): void
    {
        $this->educationTitle = $educationTitle;
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
