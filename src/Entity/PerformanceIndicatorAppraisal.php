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
use Persona\Hris\Performance\Model\AppraisalPeriodAwareInterface;
use Persona\Hris\Performance\Model\AppraisalPeriodInterface;
use Persona\Hris\Performance\Model\EmployeeIndicatorAppraisalInterface;
use Persona\Hris\Performance\Model\IndicatorAwareInterface;
use Persona\Hris\Performance\Model\IndicatorInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="ap_indicator_appraisals", indexes={
 *     @ORM\Index(name="indicator_appraisal_search_idx", columns={"employee_id", "appraisal_period_id", "indicator_id"}),
 *     @ORM\Index(name="indicator_appraisal_search_idx_supervisor", columns={"first_supervisor_appraisal_by_id", "second_supervisor_appraisal_by_id"}),
 *     @ORM\Index(name="indicator_appraisal_search_idx_employee", columns={"employee_id"}),
 *     @ORM\Index(name="indicator_appraisal_search_idx_appraisal_period", columns={"appraisal_period_id"}),
 *     @ORM\Index(name="indicator_appraisal_search_idx_indicator", columns={"indicator_id"}),
 *     @ORM\Index(name="indicator_appraisal_search_idx_first_supervisor_appraisal_by", columns={"first_supervisor_appraisal_by_id"}),
 *     @ORM\Index(name="indicator_appraisal_search_idx_second_supervisor_appraisal_by", columns={"second_supervisor_appraisal_by_id"})
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
class PerformanceIndicatorAppraisal implements EmployeeIndicatorAppraisalInterface, EmployeeAwareInterface, AppraisalPeriodAwareInterface, IndicatorAwareInterface, FirstSupervisorAppraisalByAwareInterface, SecondSupervisorAppraisalByAwareInterface, ActionLoggerAwareInterface
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
     * @Groups({"read"})
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $indicatorId;

    /**
     * @var IndicatorInterface
     */
    private $indicator;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $firstSupervisorAppraisalById;

    /**
     * @var EmployeeInterface
     */
    private $firstSupervisorAppraisalBy;

    /**
     * @Groups({"read"})
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $secondSupervisorAppraisalById;

    /**
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
    public function getIndicatorId(): string
    {
        return (string) $this->indicatorId;
    }

    /**
     * @param string $indicatorId
     */
    public function setIndicatorId(string $indicatorId = null)
    {
        $this->indicatorId = $indicatorId;
    }

    /**
     * @return IndicatorInterface
     */
    public function getIndicator(): ? IndicatorInterface
    {
        return $this->indicator;
    }

    /**
     * @param IndicatorInterface $indicator
     */
    public function setIndicator(IndicatorInterface $indicator = null): void
    {
        $this->indicator = $indicator;
        if ($indicator) {
            $this->indicatorId = $indicator->getId();
        }
    }

    /**
     * @return string
     */
    public function getFirstSupervisorAppraisalById(): string
    {
        return (string) $this->firstSupervisorAppraisalById;
    }

    /**
     * @param string $firstSupervisorAppraisalById
     */
    public function setFirstSupervisorAppraisalById(string $firstSupervisorAppraisalById = null)
    {
        $this->firstSupervisorAppraisalById = $firstSupervisorAppraisalById;
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
        if ($firstSupervisorAppraisalBy) {
            $this->firstSupervisorAppraisalById = $firstSupervisorAppraisalBy->getId();
        }
    }

    /**
     * @return string
     */
    public function getSecondSupervisorAppraisalById(): string
    {
        return (string) $this->secondSupervisorAppraisalById;
    }

    /**
     * @param string $secondSupervisorAppraisalById
     */
    public function setSecondSupervisorAppraisalById(string $secondSupervisorAppraisalById = null)
    {
        $this->secondSupervisorAppraisalById = $secondSupervisorAppraisalById;
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
        if ($secondSupervisorAppraisalBy) {
            $this->secondSupervisorAppraisalById = $secondSupervisorAppraisalBy->getId();
        }
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
