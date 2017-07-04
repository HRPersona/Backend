<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Core\Logger\ActionLoggerAwareInterface;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Employee\Model\EmployeeFamilyInterface;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Share\Model\CityInterface;
use Persona\Hris\Share\Model\EducationTitleInterface;
use Persona\Hris\Share\Model\UniversityInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="e_employee_families")
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
class EmployeeFamily implements EmployeeFamilyInterface, ActionLoggerAwareInterface
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
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\University", fetch="EAGER")
     * @ORM\JoinColumn(name="university_id", referencedColumnName="id")
     *
     * @var UniversityInterface
     */
    private $university;

    /**
     * @Groups({"read", "write"})
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\EducationTitle", fetch="EAGER")
     * @ORM\JoinColumn(name="education_title_id", referencedColumnName="id")
     *
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
    }
}
