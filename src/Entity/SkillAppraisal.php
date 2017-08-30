<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Core\Logger\Model\ActionLoggerAwareInterface;
use Persona\Hris\Employee\Model\EmployeeAwareInterface;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Employee\Model\FirstSupervisorAppraisalByAwareInterface;
use Persona\Hris\Employee\Model\SecondSupervisorAppraisalByAwareInterface;
use Persona\Hris\Performance\AppraisalAwareTrait;
use Persona\Hris\Performance\Model\AppraisalPeriodAwareInterface;
use Persona\Hris\Performance\Model\AppraisalPeriodInterface;
use Persona\Hris\Performance\Model\EmployeeSkillAppraisalInterface;
use Persona\Hris\Share\Model\SkillAwareInterface;
use Persona\Hris\Share\Model\SkillInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="ap_skill_appraisals", indexes={
 *     @ORM\Index(name="skill_appraisal_search_idx", columns={"employee_id", "appraisal_period_id", "skill_id"}),
 *     @ORM\Index(name="skill_appraisal_search_idx_supervisor", columns={"first_supervisor_appraisal_by_id", "second_supervisor_appraisal_by_id"}),
 *     @ORM\Index(name="skill_appraisal_search_idx_employee", columns={"employee_id"}),
 *     @ORM\Index(name="skill_appraisal_search_idx_appraisal_period", columns={"appraisal_period_id"}),
 *     @ORM\Index(name="skill_appraisal_search_idx_skill", columns={"skill_id"}),
 *     @ORM\Index(name="skill_appraisal_search_idx_first_supervisor_appraisal_by", columns={"first_supervisor_appraisal_by_id"}),
 *     @ORM\Index(name="skill_appraisal_search_idx_second_supervisor_appraisal_by", columns={"second_supervisor_appraisal_by_id"})
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
class SkillAppraisal implements EmployeeSkillAppraisalInterface, EmployeeAwareInterface, AppraisalPeriodAwareInterface, SkillAwareInterface, FirstSupervisorAppraisalByAwareInterface, SecondSupervisorAppraisalByAwareInterface, ActionLoggerAwareInterface
{
    use ActionLoggerAwareTrait;
    use Timestampable;
    use SoftDeletable;
    use AppraisalAwareTrait;

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
     * @Groups({"read"})
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
     * @Groups({"read"})
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $appraisalPeriodId;

    /**
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
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $skillId;

    /**
     * @var SkillInterface
     */
    private $skill;

    /**
     * @Groups({"read", "write"})
     *
     * @var string
     */
    protected $firstSupervisorAppraisalById;

    /**
     * @var EmployeeInterface
     */
    protected $firstSupervisorAppraisalBy;

    /**
     * @Groups({"read", "write"})
     *
     * @var string
     */
    protected $secondSupervisorAppraisalById;

    /**
     * @var EmployeeInterface
     */
    protected $secondSupervisorAppraisalBy;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="smallint")
     * @Assert\NotBlank()
     *
     * @var int
     */
    protected $selfAppraisal;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="smallint")
     *
     * @var int
     */
    protected $firstSupervisorAppraisal;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="smallint")
     *
     * @var int
     */
    protected $secondSupervisorAppraisal;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    protected $selfAppraisalComment;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $firstSupervisorAppraisalComment;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $secondSupervisorAppraisalComment;

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
        if ($this->employee) {
            $this->employeeId = $employee->getId();
        }
    }

    /**
     * @return string
     */
    public function getAppraisalPeriodId(): string
    {
        return (string) $this->appraisalPeriodId;
    }

    /**
     * @param string $appraisalPeriodId
     */
    public function setAppraisalPeriodId(string $appraisalPeriodId = null)
    {
        $this->appraisalPeriodId = $appraisalPeriodId;
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
        if ($appraisalPeriod) {
            $this->appraisalPeriodId = $appraisalPeriod->getId();
        }
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
     * @return string
     */
    public function getSkillId(): string
    {
        return (string) $this->skillId;
    }

    /**
     * @param string $skillId
     */
    public function setSkillId(string $skillId = null)
    {
        $this->skillId = $skillId;
    }

    /**
     * @return SkillInterface
     */
    public function getSkill(): SkillInterface
    {
        return $this->skill;
    }

    /**
     * @param SkillInterface $skill
     */
    public function setSkill(SkillInterface $skill = null): void
    {
        $this->skill = $skill;
        if ($skill) {
            $this->skillId = $skill->getId();
        }
    }
}
