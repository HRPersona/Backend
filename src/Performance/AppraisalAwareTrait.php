<?php

namespace Persona\Hris\Performance;

use Persona\Hris\Employee\Model\EmployeeInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
trait AppraisalAwareTrait
{
    /**
     * @var string
     */
    protected $firstSupervisorAppraisalById;

    /**
     * @var EmployeeInterface
     */
    protected $firstSupervisorAppraisalBy;

    /**
     * @var string
     */
    protected $secondSupervisorAppraisalById;

    /**
     * @var EmployeeInterface
     */
    protected $secondSupervisorAppraisalBy;

    /**
     * @var int
     */
    protected $selfAppraisal;

    /**
     * @var int
     */
    protected $firstSupervisorAppraisal;

    /**
     * @var int
     */
    protected $secondSupervisorAppraisal;

    /**
     * @var string
     */
    protected $selfAppraisalComment;

    /**
     * @var string
     */
    protected $firstSupervisorAppraisalComment;

    /**
     * @var string
     */
    protected $secondSupervisorAppraisalComment;

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
        return (int) $this->selfAppraisal;
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
        return (int) $this->firstSupervisorAppraisal;
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
        return (int) $this->secondSupervisorAppraisal;
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
        return (string) $this->selfAppraisalComment;
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
        return (string) $this->firstSupervisorAppraisalComment;
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
        return (string) $this->secondSupervisorAppraisalComment;
    }

    /**
     * @param string $secondSupervisorAppraisalComment
     */
    public function setSecondSupervisorAppraisalComment(string $secondSupervisorAppraisalComment)
    {
        $this->secondSupervisorAppraisalComment = $secondSupervisorAppraisalComment;
    }
}
