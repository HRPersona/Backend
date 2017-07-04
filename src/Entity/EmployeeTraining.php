<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Core\Logger\ActionLoggerAwareInterface;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Employee\Model\EmployeeTrainingInterface;
use Persona\Hris\Share\Model\UniversityInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="e_employee_trains")
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
class EmployeeTraining implements EmployeeTrainingInterface, ActionLoggerAwareInterface
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
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     *
     * @var \DateTime
     */
    private $startDate;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     *
     * @var \DateTime
     */
    private $endDate;

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
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $certificateNumber;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $certificateFile;

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
     * @return \DateTime
     */
    public function getEndDate(): \DateTime
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     */
    public function setEndDate(\DateTime $endDate)
    {
        $this->endDate = $endDate;
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
     * @return string
     */
    public function getCertificateNumber(): string
    {
        return $this->certificateNumber;
    }

    /**
     * @param string $certificateNumber
     */
    public function setCertificateNumber(string $certificateNumber)
    {
        $this->certificateNumber = $certificateNumber;
    }

    /**
     * @return string
     */
    public function getCertificateFile(): ? string
    {
        return $this->certificateFile;
    }

    /**
     * @param string $certificateFile
     */
    public function setCertificateFile(string $certificateFile)
    {
        $this->certificateFile = $certificateFile;
    }
}
