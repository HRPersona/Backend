<?php

namespace Persona\Hris\Salary;

use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Salary\Model\AdditionalBenefitRepositoryInterface;
use Persona\Hris\Salary\Model\BenefitInterface;
use Persona\Hris\Salary\Model\EmployeeBenefitInterface;
use Persona\Hris\Salary\Model\EmployeeBenefitRepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class SalaryCalculator
{
    /**
     * @var AdditionalBenefitRepositoryInterface
     */
    private $additionalBenefit;

    /**
     * @var EmployeeBenefitRepositoryInterface
     */
    private $benefit;

    /**
     * @var array
     */
    private $plusBenefits = [];

    /**
     * @var array
     */
    private $minusBenefits = [];

    /**
     * @param AdditionalBenefitRepositoryInterface $additionalBenefitRepository
     * @param EmployeeBenefitRepositoryInterface   $employeeBenefitRepository
     */
    public function __construct(AdditionalBenefitRepositoryInterface $additionalBenefitRepository, EmployeeBenefitRepositoryInterface $employeeBenefitRepository)
    {
        $this->additionalBenefit = $additionalBenefitRepository;
        $this->benefit = $employeeBenefitRepository;
    }

    /**
     * @param EmployeeInterface $employee
     *
     * @return float
     */
    public function calculate(EmployeeInterface $employee = null): float
    {
        $addition = 0;
        $reduction = 0;
        $basicSalary = $employee->getBasicSalary();
        $this->plusBenefits[$employee->getId()] = [];
        $this->minusBenefits[$employee->getId()] = [];

        foreach ($this->additionalBenefit->findByEmployee($employee) as $additionalBenefit) {
            if (BenefitInterface::TYPE_PLUS === $additionalBenefit->getBenefit()->getBenefitType()) {
                $addition += $additionalBenefit->getBenefitValue();

                $this->plusBenefits[$employee->getId()][] = ['benefit' => $additionalBenefit->getBenefit(), 'value' => $additionalBenefit->getBenefitValue()];
            } else {
                $reduction += $additionalBenefit->getBenefitValue();

                $this->minusBenefits[$employee->getId()][] = ['benefit' => $additionalBenefit->getBenefit(), 'value' => $additionalBenefit->getBenefitValue()];
            }
        }

        foreach ($this->benefit->findByEmployee($employee) as $employeeBenefit) {
            if (BenefitInterface::TYPE_PLUS === $employeeBenefit->getBenefit()->getBenefitType()) {
                $addition += $this->getBenefit($employeeBenefit, $basicSalary);

                $this->plusBenefits[$employee->getId()][] = ['benefit' => $employeeBenefit->getBenefit(), 'value' => $employeeBenefit->getBenefitValue()];
            } else {
                $reduction += $this->getBenefit($employeeBenefit, $basicSalary);

                $this->minusBenefits[$employee->getId()][] = ['benefit' => $employeeBenefit->getBenefit(), 'value' => $employeeBenefit->getBenefitValue()];
            }
        }

        return $basicSalary + $addition - $reduction;
    }

    /**
     * @param EmployeeInterface $employee
     *
     * @return array
     */
    public function getPlusBenefits(EmployeeInterface $employee): array
    {
        return $this->plusBenefits[$employee->getId()];
    }

    /**
     * @param EmployeeInterface $employee
     *
     * @return array
     */
    public function getMinusBenefits(EmployeeInterface $employee): array
    {
        return $this->minusBenefits[$employee->getId()];
    }

    /**
     * @param EmployeeBenefitInterface $employeeBenefit
     * @param float                    $basicSalary
     *
     * @return float
     */
    private function getBenefit(EmployeeBenefitInterface $employeeBenefit, float $basicSalary): float
    {
        $percentage = $employeeBenefit->getPercentageFromBasicSalary();
        if ($percentage) {
            return round(($percentage / 100) * $basicSalary, 0, PHP_ROUND_HALF_DOWN);
        }

        $percentage = $employeeBenefit->getPercentageFromBenefitValue();
        if ($percentage) {
            return round(($percentage / 100) * $employeeBenefit->getBenefitValue(), 0, PHP_ROUND_HALF_DOWN);
        }

        return $employeeBenefit->getBenefitValue();
    }
}
