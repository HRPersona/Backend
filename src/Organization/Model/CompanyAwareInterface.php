<?php

namespace Persona\Hris\Organization\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface CompanyAwareInterface
{
    /**
     * @return string
     */
    public function getCompanyId(): string;

    /**
     * @param string|null $company
     */
    public function setCompanyId(string $company = null);

    /**
     * @return null|CompanyInterface
     */
    public function getCompany(): ? CompanyInterface;

    /**
     * @param CompanyInterface|null $company
     */
    public function setCompany(CompanyInterface $company = null): void;
}
