<?php

namespace Persona\Hris\Tax;

use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Salary\Model\AdditionalBenefitRepositoryInterface;
use Persona\Hris\Salary\Model\EmployeeBenefitRepositoryInterface;
use Persona\Hris\Tax\Formula\KawinIstriKerjaFormula;
use Persona\Hris\Tax\Formula\KawinIstriTidakKerjaFormula;
use Persona\Hris\Tax\Formula\TidakKawinFormula;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class TaxCalculator
{
    /**
     * @var TidakKawinFormula
     */
    private $tidakKawin;

    /**
     * @var KawinIstriTidakKerjaFormula
     */
    private $kawinIstriTidakKerja;

    /**
     * @var KawinIstriKerjaFormula
     */
    private $kawinIstriKerja;

    /**
     * @param EmployeeBenefitRepositoryInterface $benefitRepository
     * @param AdditionalBenefitRepositoryInterface $additionalBenefitRepositor
     */
    public function __construct(EmployeeBenefitRepositoryInterface $benefitRepository, AdditionalBenefitRepositoryInterface $additionalBenefitRepositor) {
        $this->tidakKawin = new TidakKawinFormula($benefitRepository, $additionalBenefitRepositor);
        $this->kawinIstriTidakKerja = new KawinIstriTidakKerjaFormula($benefitRepository, $additionalBenefitRepositor);
        $this->kawinIstriKerja = new KawinIstriKerjaFormula($benefitRepository, $additionalBenefitRepositor);
    }

    /**
     * @param EmployeeInterface $employee
     *
     * @return float
     */
    public function calculateTax(EmployeeInterface $employee): float
    {
        $taxGroup = $employee->getTaxGroup();

        if (in_array($taxGroup, [
            EmployeeInterface::TAX_K_0,
            EmployeeInterface::TAX_K_1,
            EmployeeInterface::TAX_K_2,
            EmployeeInterface::TAX_K_3,
        ])) {
            return $this->kawinIstriTidakKerja->getCalculatedValue($employee);
        }

        if (in_array($taxGroup, [
            EmployeeInterface::TAX_KI_0,
            EmployeeInterface::TAX_KI_1,
            EmployeeInterface::TAX_KI_2,
            EmployeeInterface::TAX_KI_3,
        ])) {
            return $this->kawinIstriTidakKerja->getCalculatedValue($employee);
        }

        return $this->tidakKawin->getCalculatedValue($employee);
    }
}
