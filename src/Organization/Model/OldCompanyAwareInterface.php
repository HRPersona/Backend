<?php

namespace Persona\Hris\Organization\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface OldCompanyAwareInterface
{
    /**
     * @return string
     */
    public function getOldCompanyId(): string;

    /**
     * @param string|null $company
     */
    public function setOldCompanyId(string $company = null);

    /**
     * @return null|CompanyInterface
     */
    public function getOldCompany(): ? CompanyInterface;

    /**
     * @param CompanyInterface|null $company
     */
    public function setOldCompany(CompanyInterface $company = null): void;
}
