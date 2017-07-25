<?php

namespace Persona\Hris\Performance\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface AppraisalPeriodRepositoryInterface
{
    /**
     * @param AppraisalPeriodInterface $appraisalPeriod
     */
    public function inactiveOthers(AppraisalPeriodInterface $appraisalPeriod): void;
}
