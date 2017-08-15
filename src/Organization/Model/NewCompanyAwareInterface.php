<?php

namespace Persona\Hris\Organization\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface NewCompanyAwareInterface
{
    /**
     * @return string
     */
    public function getNewCompanyId(): string;

    /**
     * @param string|null $company
     */
    public function setNewCompanyId(string $company = null);

    /**
     * @return null|CompanyInterface
     */
    public function getNewCompany(): ? CompanyInterface;

    /**
     * @param CompanyInterface|null $company
     */
    public function setNewCompany(CompanyInterface $company = null): void;
}
