<?php

namespace Persona\Hris\Performance\Model;

use Persona\Hris\Repository\RepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface AppraisalPeriodRepositoryInterface extends RepositoryInterface
{
    /**
     * @param AppraisalPeriodInterface $appraisalPeriod
     */
    public function inactiveOthers(AppraisalPeriodInterface $appraisalPeriod): void;
}
