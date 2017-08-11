<?php

namespace Persona\Hris\Organization\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface ParentCompanyAwareInterface
{
    /**
     * @return string
     */
    public function getParentId(): string;

    /**
     * @param string|null $company
     */
    public function setParentId(string $company = null);

    /**
     * @return null|CompanyInterface
     */
    public function getParent(): ? CompanyInterface;

    /**
     * @param CompanyInterface|null $company
     */
    public function setParent(CompanyInterface $company = null): void;
}
