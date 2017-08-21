<?php

namespace Persona\Hris\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Persona\Hris\Employee\Model\EmployeeInterface;
use Persona\Hris\Entity\Payroll;
use Persona\Hris\Entity\PayrollDetail;
use Persona\Hris\Salary\Model\BenefitInterface;
use Persona\Hris\Salary\Model\PayrollInterface;
use Persona\Hris\Salary\SalaryCalculator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class CalculateSalaryController extends Controller
{
    /**
     * @ApiDoc(
     *     section="Utilities",
     *     description="Salary Calculator",
     *     requirements={
     *      {
     *          "name"="year",
     *          "dataType"="integer",
     *          "description"="Year"
     *      },
     *      {
     *          "name"="month",
     *          "dataType"="integer",
     *          "description"="Month"
     *      }
     *  })
     *
     * @Route(name="salary_calculation", path="/employee/salary/calculate.json")
     *
     * @Method({"POST"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function calculateAction(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('n'));

        $employeeRepository = $this->container->get('persona.repository.orm.employee_repository');
        $payrollRepository = $this->container->get('persona.repository.orm.payroll_repository');
        $manager = $this->container->get('persona.manager.manager_factory')->getWriteManager();

        foreach ($employeeRepository->findActiveEmployee() as $key => $employee) {
            if ($payrollRepository->isClosed($employee, $year, $month)) {
                continue;
            }

            $salaryCalculator = $this->container->get('persona.salary.salary_calculator');
            $salaryCalculator->calculate($employee);
            $overtime = 0;

            $employeeOvertime = $this->container->get('persona.repository.orm.employee_overtime_history_repository');
            if ($employee->isHaveOvertimeBenefit()) {
                $overtime = $employeeOvertime->getHistoryByEmployee($employee, $year, $month);
            }

            if ($exist = $payrollRepository->findByEmployeeAndPeriod($employee, $year, $month)) {
                $payroll = $exist;
            } else {
                $payroll = new Payroll();
            }

            $payroll->setEmployee($employee);
            $payroll->setPayrollYear($year);
            $payroll->setPayrollMonth($month);
            $payroll->setBasicSalary($employee->getBasicSalary());
            $payroll->setOvertimeValue($overtime);
            $payroll->setTakeHomePay($salaryCalculator->getGrossSalary() + $overtime);

            $manager->persist($payroll);
            $this->saveSalaryBenefit($salaryCalculator, $employee, $payroll);

            if (0 === $key % 17) {
                $manager->flush();
            }
        }

        $manager->flush();

        return new JsonResponse(['status' => JsonResponse::HTTP_CREATED, 'message' => 'Employee salary has been calculated']);
    }

    /**
     * @ApiDoc(
     *     section="Utilities",
     *     description="Salary Calculator per Employee",
     *     requirements={
     *      {
     *          "name"="year",
     *          "dataType"="integer",
     *          "description"="Year"
     *      },
     *      {
     *          "name"="month",
     *          "dataType"="integer",
     *          "description"="Month"
     *      }
     *  })
     *
     * @Route(name="salary_calculation_per_employee", path="/employee/{id}/salary/calculate.json")
     *
     * @Method({"POST"})
     *
     * @param Request $request
     * @param string  $id
     *
     * @return JsonResponse
     */
    public function calculateEmployeeAction(Request $request, string $id)
    {
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('n'));

        $employeeRepository = $this->container->get('persona.repository.orm.employee_repository');
        $payrollRepository = $this->container->get('persona.repository.orm.payroll_repository');
        $manager = $this->container->get('persona.manager.manager_factory')->getWriteManager();

        $employee = $employeeRepository->find($id);
        if (!$employee) {
            throw new NotFoundHttpException(sprintf('Employee with id %s is not found.', $id));
        }

        if ($payrollRepository->isClosed($employee, $year, $month)) {
            throw new BadRequestHttpException(sprintf('Payroll for %s is closed.', $employee->getFullName()));
        }

        $salaryCalculator = $this->container->get('persona.salary.salary_calculator');
        $salaryCalculator->calculate($employee);

        $overtime = 0;
        $employeeOvertime = $this->container->get('persona.repository.orm.employee_overtime_history_repository');
        if ($employee->isHaveOvertimeBenefit()) {
            $overtime = $employeeOvertime->getHistoryByEmployee($employee, $year, $month);
        }

        if ($exist = $payrollRepository->findByEmployeeAndPeriod($employee, $year, $month)) {
            $payroll = $exist;
        } else {
            $payroll = new Payroll();
        }

        $payroll->setEmployee($employee);
        $payroll->setPayrollYear($year);
        $payroll->setPayrollMonth($month);
        $payroll->setBasicSalary($employee->getBasicSalary());
        $payroll->setOvertimeValue($overtime);
        $payroll->setTakeHomePay($salaryCalculator->getGrossSalary() + $overtime);

        $manager->persist($payroll);
        $this->saveSalaryBenefit($salaryCalculator, $employee, $payroll);
        $manager->flush();

        return new JsonResponse(['status' => JsonResponse::HTTP_CREATED, 'message' => 'Employee salary has been calculated']);
    }

    /**
     * @param SalaryCalculator  $salaryCalculator
     * @param EmployeeInterface $employee
     * @param PayrollInterface  $payroll
     */
    private function saveSalaryBenefit(SalaryCalculator $salaryCalculator, EmployeeInterface $employee, PayrollInterface $payroll)
    {
        $payrollDetailRepository = $this->container->get('persona.repository.orm.payroll_detail_repository');
        $manager = $this->container->get('persona.manager.manager_factory')->getWriteManager();

        foreach ($salaryCalculator->getPlusBenefits($employee) as $k => $benefit) {
            if ($existDetail = $payrollDetailRepository->findByPayrollAndBenefit($payroll, $benefit)) {
                $payrollDetail = $existDetail;
            } else {
                $payrollDetail = new PayrollDetail();
            }

            $payrollDetail->setPayroll($payroll);
            $payrollDetail->setBenefit($benefit['benefit']);
            $payrollDetail->setBenefitValue($benefit['value']);
            $payrollDetail->setBenefitType(BenefitInterface::TYPE_PLUS);

            $manager->persist($payrollDetail);
            if (0 === $k % 17) {
                $manager->flush();
            }
        }

        foreach ($salaryCalculator->getMinusBenefits($employee) as $i => $benefit) {
            if ($existDetail = $payrollDetailRepository->findByPayrollAndBenefit($payroll, $benefit)) {
                $payrollDetail = $existDetail;
            } else {
                $payrollDetail = new PayrollDetail();
            }

            $payrollDetail->setPayroll($payroll);
            $payrollDetail->setBenefit($benefit['benefit']);
            $payrollDetail->setBenefitValue($benefit['value']);
            $payrollDetail->setBenefitType(BenefitInterface::TYPE_MINUS);

            $manager->persist($payrollDetail);
            if (0 === $i % 17) {
                $manager->flush();
            }
        }
    }
}
