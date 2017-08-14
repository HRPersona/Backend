<?php

namespace Persona\Hris\Salary\Model;

use Persona\Hris\Repository\RepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface BenefitRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $id
     *
     * @return BenefitInterface|null
     */
    public function find(string $id): ? BenefitInterface;
}
