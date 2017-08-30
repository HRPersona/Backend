<?php

namespace Persona\Hris\Performance\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface AppraisalAwareInterface
{
    /**
     * @return int
     */
    public function getSelfAppraisal(): int;

    /**
     * @return int
     */
    public function getFirstSupervisorAppraisal(): int;

    /**
     * @return int
     */
    public function getSecondSupervisorAppraisal(): int;

    /**
     * @return string
     */
    public function getSelfAppraisalComment(): string;

    /**
     * @return string
     */
    public function getFirstSupervisorAppraisalComment(): string;

    /**
     * @return string
     */
    public function getSecondSupervisorAppraisalComment(): string;
}
