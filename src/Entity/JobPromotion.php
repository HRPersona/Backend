<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Allocation\Model\PromotionInterface;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Core\Logger\Model\ActionLoggerAwareInterface;
use Persona\Hris\Employee\Model\EmployeeAwareInterface;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Organization\Model\JobTitleInterface;
use Persona\Hris\Organization\Model\NewJobTitleAwareInterface;
use Persona\Hris\Organization\Model\OldJobTitleAwareInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="ja_promotions", indexes={
 *     @ORM\Index(name="promotion_search_idx", columns={"employee_id", "old_jobtitle_id", "new_jobtitle_id"}),
 *     @ORM\Index(name="promotion_search_employee_id", columns={"employee_id"}),
 *     @ORM\Index(name="promotion_search_old_jobtitle", columns={"old_jobtitle_id"}),
 *     @ORM\Index(name="promotion_search_new_jobtitle", columns={"new_jobtitle_id"})
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
class JobPromotion implements PromotionInterface, EmployeeAwareInterface, OldJobTitleAwareInterface, NewJobTitleAwareInterface, ActionLoggerAwareInterface
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
     * @ORM\Column(type="string", name="old_jobtitle_id", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $oldJobTitleId;

    /**
     * @var JobTitleInterface
     */
    private $oldJobTitle;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", name="new_jobtitle_id", nullable=true)
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $newJobTitleId;

    /**
     * @var JobTitleInterface
     */
    private $newJobTitle;

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
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $letterNumber;

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
    public function getOldJobTitleId(): string
    {
        return (string) $this->oldJobTitleId;
    }

    /**
     * @param string $oldJobTitleId
     */
    public function setOldJobTitleId(string $oldJobTitleId = null)
    {
        $this->oldJobTitleId = $oldJobTitleId;
    }

    /**
     * @return JobTitleInterface
     */
    public function getOldJobTitle(): ? JobTitleInterface
    {
        return $this->oldJobTitle;
    }

    /**
     * @param JobTitleInterface $oldJobTitle
     */
    public function setOldJobTitle(JobTitleInterface $oldJobTitle = null): void
    {
        $this->oldJobTitle = $oldJobTitle;
        if ($oldJobTitle) {
            $this->oldJobTitleId = $oldJobTitle->getId();
        }
    }

    /**
     * @return string
     */
    public function getNewJobTitleId(): string
    {
        return (string) $this->newJobTitleId;
    }

    /**
     * @param string $newJobTitleId
     */
    public function setNewJobTitleId(string $newJobTitleId = null)
    {
        $this->newJobTitleId = $newJobTitleId;
    }

    /**
     * @return JobTitleInterface
     */
    public function getNewJobTitle(): ? JobTitleInterface
    {
        return $this->newJobTitle;
    }

    /**
     * @param JobTitleInterface $newJobTitle
     */
    public function setNewJobTitle(JobTitleInterface $newJobTitle = null): void
    {
        $this->newJobTitle = $newJobTitle;
        if ($newJobTitle) {
            $this->newJobTitleId = $newJobTitle->getId();
        }
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
     * @return string
     */
    public function getLetterNumber(): string
    {
        return $this->letterNumber;
    }

    /**
     * @param string $letterNumber
     */
    public function setLetterNumber(string $letterNumber)
    {
        $this->letterNumber = $letterNumber;
    }
}
