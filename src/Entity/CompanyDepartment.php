<?php

namespace Persona\Hris\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Core\Logger\Model\ActionLoggerAwareInterface;
use Persona\Hris\Organization\Model\CompanyAwareInterface;
use Persona\Hris\Organization\Model\CompanyDepartmentInterface;
use Persona\Hris\Organization\Model\CompanyInterface;
use Persona\Hris\Organization\Model\DepartmentAwareInterface;
use Persona\Hris\Organization\Model\DepartmentInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="og_company_departments", indexes={
 *     @ORM\Index(name="company_department_search_idx", columns={"company_id", "department_id"}),
 *     @ORM\Index(name="company_department_search_idx_company", columns={"company_id"}),
 *     @ORM\Index(name="company_department_search_idx_department", columns={"department_id"})
 * })
 *
 * @ApiResource(
 *     attributes={
 *         "filters"={
 *             "order.filter"
 *         },
 *         "normalization_context"={"groups"={"read"}},
 *         "denormalization_context"={"groups"={"write"}}
 *     }
 * )
 *
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
class CompanyDepartment implements CompanyDepartmentInterface, CompanyAwareInterface, DepartmentAwareInterface, ActionLoggerAwareInterface
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
    private $companyId;

    /**
     * @var CompanyInterface
     */
    private $company;

    /**
     * @Groups({"read", "write"})
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     *
     * @var string
     */
    private $departmentId;

    /**
     * @var DepartmentInterface
     */
    private $department;

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
    public function getCompanyId(): string
    {
        return $this->companyId;
    }

    /**
     * @param string $companyId
     */
    public function setCompanyId(string $companyId = null)
    {
        $this->companyId = $companyId;
    }

    /**
     * @return CompanyInterface
     */
    public function getCompany(): CompanyInterface
    {
        return $this->company;
    }

    /**
     * @param CompanyInterface $company
     */
    public function setCompany(CompanyInterface $company = null): void
    {
        $this->company = $company;
        if ($company) {
            $this->companyId = $company->getId();
        }
    }

    /**
     * @return string
     */
    public function getDepartmentId(): string
    {
        return $this->departmentId;
    }

    /**
     * @param string $departmentId
     */
    public function setDepartmentId(string $departmentId = null)
    {
        $this->departmentId = $departmentId;
    }

    /**
     * @return DepartmentInterface
     */
    public function getDepartment(): DepartmentInterface
    {
        return $this->department;
    }

    /**
     * @param DepartmentInterface $department
     */
    public function setDepartment(DepartmentInterface $department = null): void
    {
        $this->department = $department;
        if ($department) {
            $this->departmentId = $department->getId();
        }
    }
}
