<?php

namespace Persona\Hris\Overtime;

use Persona\Hris\Attendance\Model\EmployeeShiftmentRepositoryInterface;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Overtime\Formula\HolidayFormula;
use Persona\Hris\Overtime\Formula\WorkdayFormula;
use Persona\Hris\Overtime\Model\EmployeeOvertimeRepositoryInterface;
use Persona\Hris\Overtime\Model\HolidayRepositoryInterface;
use Persona\Hris\Salary\Model\BenefitInterface;
use Persona\Hris\Salary\Model\EmployeeBenefitInterface;
use Persona\Hris\Salary\Model\EmployeeBenefitRepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class OvertimeCalculator
{
    /**
     * @var WorkdayFormula
     */
    private $workdayFormula;

    /**
     * @var HolidayFormula
     */
    private $holidayFormula;

    /**
     * @var EmployeeOvertimeRepositoryInterface
     */
    private $employeeOvertimeRepository;

    /**
     * @var EmployeeBenefitRepositoryInterface
     */
    private $employeeBenefitRepository;

    /**
     * @var EmployeeShiftmentRepositoryInterface
     */
    private $employeeShiftmentRepository;

    /**
     * @var HolidayRepositoryInterface
     */
    private $holidayRepository;

    public function __construct(
        EmployeeOvertimeRepositoryInterface $overtimeRepository,
        EmployeeBenefitRepositoryInterface $benefitRepository,
        EmployeeShiftmentRepositoryInterface $shiftmentRepository,
        HolidayRepositoryInterface $holidayRepository
    ) {
        $this->employeeOvertimeRepository = $overtimeRepository;
        $this->employeeBenefitRepository = $benefitRepository;
        $this->employeeShiftmentRepository = $shiftmentRepository;
        $this->holidayRepository = $holidayRepository;

        $this->workdayFormula = new WorkdayFormula();
        $this->holidayFormula = new HolidayFormula();
    }

    /**
     * @param \DateTime $date
     * @param EmployeeInterface|null $employee
     * @return float
     */
    public function calculate(\DateTime $date, EmployeeInterface $employee = null): float
    {
        $calculatedValue = 0;
        $fixedSalary = $this->getFixedSalary($employee);
        foreach ($this->employeeOvertimeRepository->findByEmployee($date, $employee) as $employeeOvertime) {
            if ($employeeOvertime->isOffTime() || $this->isTimeOff($employee, $employeeOvertime->getOvertimeDate())) {
                $calculatedValue += $this->holidayFormula->getCalculatedValue($employeeOvertime->getOvertimeValue());
            } else {
                $calculatedValue += $this->workdayFormula->getCalculatedValue($employeeOvertime->getOvertimeValue());
            }
        }

        return round(($calculatedValue / 173) * $fixedSalary, 0, PHP_ROUND_HALF_DOWN);
    }

    /**
     * @param EmployeeInterface $employee
     *
     * @return float
     */
    private function getFixedSalary(EmployeeInterface $employee): float
    {
        $addition = 0;
        $reduction = 0;
        $basicSalary = $employee->getBasicSalary();

        foreach ($this->employeeBenefitRepository->findByEmployee($employee) as $employeeBenefit) {
            if (BenefitInterface::TYPE_PLUS === $employeeBenefit->getBenefit()->getBenefitType()) {
                $addition += $this->getBenefit($employeeBenefit, $basicSalary);
            } else {
                $reduction += $this->getBenefit($employeeBenefit, $basicSalary);
            }
        }

        return $basicSalary + $addition - $reduction;
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

    /**
     * @param EmployeeInterface $employee
     * @param \DateTime         $date
     *
     * @return bool
     */
    private function isTimeOff(EmployeeInterface $employee, \DateTime $date): bool
    {
        return $this->holidayRepository->isTimeOff($date) && $this->employeeShiftmentRepository->isTimeOff($employee, $date);
    }
}
