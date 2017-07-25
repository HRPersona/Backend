<?php

namespace Persona\Hris\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Persona\Hris\Entity\TaxHistory;
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
final class CalculateTaxController extends Controller
{
    /**
     * @ApiDoc(
     *     section="Utilities",
     *     description="Tax Calculator",
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
     * @Route(name="tax_calculation", path="/employee/tax/calculate.json")
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

        $taxCalculator = $this->container->get('persona.tax.tax_calculator');
        $employeeRepository = $this->container->get('persona.repository.orm.employee_repository');
        $payrollRepository = $this->container->get('persona.repository.orm.payroll_repository');
        $manager = $this->container->get('persona.manager.manager_factory')->getWriteManager();

        foreach ($employeeRepository->findActiveEmployee() as $key => $employee) {
            if (!$payrollRepository->isClosed($employee, $year, $month)) {
                continue;
            }

            $taxHistoryRepository = $this->container->get('persona.repository.orm.tax_history_repository');
            if ($exist = $taxHistoryRepository->findByEmployeeAndPeriod($employee, $year, $month)) {
                $taxHistory = $exist;
            } else {
                $taxHistory = new TaxHistory();
            }

            $taxHistory->setEmployee($employee);
            $taxHistory->setTaxYear($year);
            $taxHistory->setTaxMonth($month);
            $taxHistory->setTaxValue($taxCalculator->calculateTax($employee));

            $manager->persist($taxHistory);

            if (0 === $key % 17) {
                $manager->flush();
            }
        }

        $manager->flush();

        return new JsonResponse(['status' => JsonResponse::HTTP_CREATED, 'message' => 'Employee tax has been calculated']);
    }

    /**
     * @ApiDoc(
     *     section="Utilities",
     *     description="Tax Calculator per Emploee",
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
     * @Route(name="tax_calculation_per_employee", path="/employee/{id}/tax/calculate.json")
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

        $taxCalculator = $this->container->get('persona.tax.tax_calculator');
        $employeeRepository = $this->container->get('persona.repository.orm.employee_repository');
        $payrollRepository = $this->container->get('persona.repository.orm.payroll_repository');
        $manager = $this->container->get('persona.manager.manager_factory')->getWriteManager();

        $employee = $employeeRepository->find($id);
        if (!$employee) {
            throw new NotFoundHttpException(sprintf('Employee with id %s is not found.', $id));
        }

        if (!$payrollRepository->isClosed($employee, $year, $month)) {
            throw new BadRequestHttpException(sprintf('Payroll for %s is not closed.', $employee->getFullName()));
        }

        $taxHistoryRepository = $this->container->get('persona.repository.orm.tax_history_repository');
        if ($exist = $taxHistoryRepository->findByEmployeeAndPeriod($employee, $year, $month)) {
            $taxHistory = $exist;
        } else {
            $taxHistory = new TaxHistory();
        }

        $taxHistory->setEmployee($employee);
        $taxHistory->setTaxYear($year);
        $taxHistory->setTaxMonth($month);
        $taxHistory->setTaxValue($taxCalculator->calculateTax($employee));

        $manager->persist($taxHistory);

        $manager->flush();

        return new JsonResponse(['status' => JsonResponse::HTTP_CREATED, 'message' => 'Employee tax has been calculated']);
    }
}
