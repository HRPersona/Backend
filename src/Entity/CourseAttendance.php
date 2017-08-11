<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Core\Logger\Model\ActionLoggerAwareInterface;
use Persona\Hris\Course\Model\CourseAttendanceInterface;
use Persona\Hris\Course\Model\CourseAwareInterface;
use Persona\Hris\Course\Model\CourseInterface;
use Persona\Hris\Employee\Model\EmployeeAwareInterface;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="cr_course_attendances", indexes={
 *     @ORM\Index(name="course_attendance_search_idx", columns={"course_id", "employee_id"}),
 *     @ORM\Index(name="course_attendance_search_course", columns={"course_id"}),
 *     @ORM\Index(name="course_attendance_search_employee", columns={"employee_id"})
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
class CourseAttendance implements CourseAttendanceInterface, CourseAwareInterface, EmployeeAwareInterface, ActionLoggerAwareInterface
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
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $courseId;

    /**
     * @var CourseInterface
     */
    private $course;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string")
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
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $certificateNumber;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
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
     * @return string
     */
    public function getCourseId(): string
    {
        return $this->courseId;
    }

    /**
     * @param string $courseId
     */
    public function setCourseId(string $courseId = null)
    {
        $this->courseId = $courseId;
    }

    /**
     * @return CourseInterface
     */
    public function getCourse(): ? CourseInterface
    {
        return $this->course;
    }

    /**
     * @param CourseInterface $course
     */
    public function setCourse(CourseInterface $course = null): void
    {
        $this->course = $course;
        if ($course) {
            $this->courseId = $course->getId();
        }
    }

    /**
     * @return string
     */
    public function getEmployeeId(): string
    {
        return $this->employeeId;
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
    public function getCertificateFile(): string
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
