<?php

namespace Persona\Hris\Tax;

use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Salary\Model\PayrollDetailRepositoryInterface;
use Persona\Hris\Salary\Model\PayrollInterface;
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
     * @param PayrollDetailRepositoryInterface $payrollDetailRepository
     */
    public function __construct(PayrollDetailRepositoryInterface $payrollDetailRepository)
    {
        $this->tidakKawin = new TidakKawinFormula($payrollDetailRepository);
        $this->kawinIstriTidakKerja = new KawinIstriTidakKerjaFormula($payrollDetailRepository);
        $this->kawinIstriKerja = new KawinIstriKerjaFormula($payrollDetailRepository);
    }

    /**
     * @param PayrollInterface $payroll
     *
     * @return float
     */
    public function calculateTax(PayrollInterface $payroll): float
    {
        $taxGroup = $payroll->getEmployee()->getTaxGroup();

        if (in_array($taxGroup, [
            EmployeeInterface::TAX_K_0,
            EmployeeInterface::TAX_K_1,
            EmployeeInterface::TAX_K_2,
            EmployeeInterface::TAX_K_3,
        ])) {
            return $this->kawinIstriTidakKerja->getCalculatedValue($payroll);
        }

        if (in_array($taxGroup, [
            EmployeeInterface::TAX_KI_0,
            EmployeeInterface::TAX_KI_1,
            EmployeeInterface::TAX_KI_2,
            EmployeeInterface::TAX_KI_3,
        ])) {
            return $this->kawinIstriKerja->getCalculatedValue($payroll);
        }

        return $this->tidakKawin->getCalculatedValue($payroll);
    }
}
