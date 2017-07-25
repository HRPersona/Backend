<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Core\Logger\ActionLoggerAwareInterface;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Performance\Model\AppraisalPeriodInterface;
use Persona\Hris\Performance\Model\EmployeeSkillAppraisalInterface;
use Persona\Hris\Share\Model\SkillInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="ap_skill_appraisals")
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
class SkillAppraisal implements EmployeeSkillAppraisalInterface, ActionLoggerAwareInterface
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
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\AppraisalPeriod", fetch="EAGER")
     * @ORM\JoinColumn(name="appraisal_period_id", referencedColumnName="id")
     * @Assert\NotBlank()
     *
     * @var AppraisalPeriodInterface
     */
    private $appraisalPeriod;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     *
     * @var \DateTime
     */
    private $inputDate;

    /**
     * @Groups({"read", "write"})
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\Skill", fetch="EAGER")
     * @ORM\JoinColumn(name="skill_id", referencedColumnName="id")
     * @Assert\NotBlank()
     *
     * @var SkillInterface
     */
    private $skill;

    /**
     * @Groups({"read", "write"})
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\Employee", fetch="EAGER")
     * @ORM\JoinColumn(name="first_supervisor_id", referencedColumnName="id")
     * @Assert\NotBlank()
     *
     * @var EmployeeInterface
     */
    private $firstSupervisorAppraisalBy;

    /**
     * @Groups({"read", "write"})
     * @ORM\ManyToOne(targetEntity="Persona\Hris\Entity\Employee", fetch="EAGER")
     * @ORM\JoinColumn(name="second_supervisor_id", referencedColumnName="id")
     * @Assert\NotBlank()
     *
     * @var EmployeeInterface
     */
    private $secondSupervisorAppraisalBy;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="smallint")
     * @Assert\NotBlank()
     *
     * @var int
     */
    private $selfAppraisal;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="smallint")
     * @Assert\NotBlank()
     *
     * @var int
     */
    private $firstSupervisorAppraisal;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="smallint")
     * @Assert\NotBlank()
     *
     * @var int
     */
    private $secondSupervisorAppraisal;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $selfAppraisalComment;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $firstSupervisorAppraisalComment;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $secondSupervisorAppraisalComment;

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
     * @return AppraisalPeriodInterface
     */
    public function getAppraisalPeriod(): ? AppraisalPeriodInterface
    {
        return $this->appraisalPeriod;
    }

    /**
     * @param AppraisalPeriodInterface $appraisalPeriod
     */
    public function setAppraisalPeriod(AppraisalPeriodInterface $appraisalPeriod = null): void
    {
        $this->appraisalPeriod = $appraisalPeriod;
    }

    /**
     * @return \DateTime
     */
    public function getInputDate(): \DateTime
    {
        return $this->inputDate;
    }

    /**
     * @param \DateTime $inputDate
     */
    public function setInputDate(\DateTime $inputDate)
    {
        $this->inputDate = $inputDate;
    }

    /**
     * @return SkillInterface
     */
    public function getSkill(): ? SkillInterface
    {
        return $this->skill;
    }

    /**
     * @param SkillInterface $skill
     */
    public function setSkill(SkillInterface $skill = null): void
    {
        $this->skill = $skill;
    }

    /**
     * @return EmployeeInterface
     */
    public function getFirstSupervisorAppraisalBy(): ? EmployeeInterface
    {
        return $this->firstSupervisorAppraisalBy;
    }

    /**
     * @param EmployeeInterface $firstSupervisorAppraisalBy
     */
    public function setFirstSupervisorAppraisalBy(EmployeeInterface $firstSupervisorAppraisalBy = null): void
    {
        $this->firstSupervisorAppraisalBy = $firstSupervisorAppraisalBy;
    }

    /**
     * @return EmployeeInterface
     */
    public function getSecondSupervisorAppraisalBy(): ? EmployeeInterface
    {
        return $this->secondSupervisorAppraisalBy;
    }

    /**
     * @param EmployeeInterface $secondSupervisorAppraisalBy
     */
    public function setSecondSupervisorAppraisalBy(EmployeeInterface $secondSupervisorAppraisalBy = null): void
    {
        $this->secondSupervisorAppraisalBy = $secondSupervisorAppraisalBy;
    }

    /**
     * @return int
     */
    public function getSelfAppraisal(): int
    {
        return $this->selfAppraisal;
    }

    /**
     * @param int $selfAppraisal
     */
    public function setSelfAppraisal(int $selfAppraisal)
    {
        $this->selfAppraisal = $selfAppraisal;
    }

    /**
     * @return int
     */
    public function getFirstSupervisorAppraisal(): int
    {
        return $this->firstSupervisorAppraisal;
    }

    /**
     * @param int $firstSupervisorAppraisal
     */
    public function setFirstSupervisorAppraisal(int $firstSupervisorAppraisal)
    {
        $this->firstSupervisorAppraisal = $firstSupervisorAppraisal;
    }

    /**
     * @return int
     */
    public function getSecondSupervisorAppraisal(): int
    {
        return $this->secondSupervisorAppraisal;
    }

    /**
     * @param int $secondSupervisorAppraisal
     */
    public function setSecondSupervisorAppraisal(int $secondSupervisorAppraisal)
    {
        $this->secondSupervisorAppraisal = $secondSupervisorAppraisal;
    }

    /**
     * @return string
     */
    public function getSelfAppraisalComment(): string
    {
        return $this->selfAppraisalComment;
    }

    /**
     * @param string $selfAppraisalComment
     */
    public function setSelfAppraisalComment(string $selfAppraisalComment)
    {
        $this->selfAppraisalComment = $selfAppraisalComment;
    }

    /**
     * @return string
     */
    public function getFirstSupervisorAppraisalComment(): string
    {
        return $this->firstSupervisorAppraisalComment;
    }

    /**
     * @param string $firstSupervisorAppraisalComment
     */
    public function setFirstSupervisorAppraisalComment(string $firstSupervisorAppraisalComment)
    {
        $this->firstSupervisorAppraisalComment = $firstSupervisorAppraisalComment;
    }

    /**
     * @return string
     */
    public function getSecondSupervisorAppraisalComment(): string
    {
        return $this->secondSupervisorAppraisalComment;
    }

    /**
     * @param string $secondSupervisorAppraisalComment
     */
    public function setSecondSupervisorAppraisalComment(string $secondSupervisorAppraisalComment)
    {
        $this->secondSupervisorAppraisalComment = $secondSupervisorAppraisalComment;
    }
}
