<?php

namespace Persona\Hris\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Persona\Hris\Entity\EmployeeOvertimeCalculation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class CalculateOvertimeController extends Controller
{
    /**
     * @ApiDoc(
     *     section="Utilities",
     *     description="Overtime Calculator",
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
     * @Route(name="overtime_calculation", path="/employee/overtime/calculate.json")
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

        $date = \DateTime::createFromFormat('Y-n-j', sprintf('%s-%s-1', $year, $month));

        $overtimeCalculator = $this->container->get('persona.overtime.overtime_calculator');
        $employeeRepository = $this->container->get('persona.repository.orm.employee_repository');
        $employeeCalculationRepository = $this->container->get('persona.repository.orm.employee_overtime_calculation_repository');
        $manager = $this->container->get('persona.manager.manager_factory')->getWriteManager();

        foreach ($employeeRepository->findActiveEmployee() as $key => $employee) {
            if ($employeeCalculationRepository->isExisting($employee, $year, $month)) {
                $overtimeCalculation = $employeeCalculationRepository->getExistData();
            } else {
                $overtimeCalculation = new EmployeeOvertimeCalculation();
            }
            $overtimeCalculation->setEmployee($employee);
            $overtimeCalculation->setOvertimeYear($year);
            $overtimeCalculation->setOvertimeMonth($month);
            $overtimeCalculation->setCalculatedValue($overtimeCalculator->calculate($date, $employee));

            $manager->persist($overtimeCalculation);
            if (0 === $key % 17) {
                $manager->flush();
            }
        }

        $manager->flush();

        return new JsonResponse(['status' => JsonResponse::HTTP_CREATED, 'message' => 'Employee overtime has been calculated']);
    }
}
