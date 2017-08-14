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
use Persona\Hris\Employee\Model\EmployeeSkillInterface;
use Persona\Hris\Share\Model\SkillAwareInterface;
use Persona\Hris\Share\Model\SkillInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="em_employee_skills", indexes={
 *     @ORM\Index(name="employee_education_search_idx", columns={"employee_id", "skill_id"}),
 *     @ORM\Index(name="employee_education_search_employee", columns={"employee_id"}),
 *     @ORM\Index(name="employee_education_search_skill", columns={"skill_id"})
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
class EmployeeSkill implements EmployeeSkillInterface, EmployeeAwareInterface, SkillAwareInterface, ActionLoggerAwareInterface
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
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $level;

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
        if ($this->employee) {
            $this->employeeId = $employee->getId();
        }
    }

    /**
     * @return string
     */
    public function getSkillId(): string
    {
        return $this->skillId;
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
    }

    /**
     * @return string
     */
    public function getLevel(): string
    {
        return $this->level;
    }

    /**
     * @param string $level
     */
    public function setLevel(string $level)
    {
        if (!in_array($level, [SkillInterface::LEVEL_BEGINNER, SkillInterface::LEVEL_INTERMEDIATE, SkillInterface::LEVEL_ADVANCED, SkillInterface::LEVEL_EXPERT])) {
            throw new \InvalidArgumentException(sprintf('%s is not valid skill level', $level));
        }

        $this->level = $level;
    }
}
