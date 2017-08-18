<?php

namespace Persona\Hris\Performance\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface AppraisalPeriodAwareInterface
{
    /**
     * @return string
     */
    public function getAppraisalPeriodId(): string;

    /**
     * @param string|null $appraisalPeriod
     */
    public function setAppraisalPeriodId(string $appraisalPeriod = null);

    /**
     * @return null|AppraisalPeriodInterface
     */
    public function getAppraisalPeriod(): ? AppraisalPeriodInterface;

    /**
     * @param AppraisalPeriodInterface|null $appraisalPeriod
     */
    public function setAppraisalPeriod(AppraisalPeriodInterface $appraisalPeriod = null): void;
}
