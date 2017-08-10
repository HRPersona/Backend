<?php

namespace Persona\Hris\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Persona\Hris\Entity\OvertimeHistory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $employeeHistoryRepository = $this->container->get('persona.repository.orm.employee_overtime_history_repository');
        $manager = $this->container->get('persona.manager.manager_factory')->getWriteManager();

        foreach ($employeeRepository->findActiveEmployee() as $key => $employee) {
            if ($employeeHistoryRepository->isClosed($employee, $year, $month)) {
                continue;
            }

            if ($employeeHistoryRepository->isExisting($employee, $year, $month)) {
                $overtimeHistory = $employeeHistoryRepository->getExistingData();
            } else {
                $overtimeHistory = new OvertimeHistory();
            }

            $overtimeHistory->setEmployee($employee);
            $overtimeHistory->setOvertimeYear($year);
            $overtimeHistory->setOvertimeMonth($month);
            $overtimeHistory->setCalculatedValue($overtimeCalculator->calculate($date, $employee));

            $manager->persist($overtimeHistory);
            if (0 === $key % 17) {
                $manager->flush();
            }
        }

        $manager->flush();

        return new JsonResponse(['status' => JsonResponse::HTTP_CREATED, 'message' => 'Employee overtime has been calculated']);
    }

    /**
     * @ApiDoc(
     *     section="Utilities",
     *     description="Overtime Calculator per Employee",
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
     * @Route(name="overtime_calculation_per_employee", path="/employee/{id}/overtime/calculate.json")
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

        $date = \DateTime::createFromFormat('Y-n-j', sprintf('%s-%s-1', $year, $month));

        $overtimeCalculator = $this->container->get('persona.overtime.overtime_calculator');
        $employeeRepository = $this->container->get('persona.repository.orm.employee_repository');
        $employeeHistoryRepository = $this->container->get('persona.repository.orm.employee_overtime_history_repository');
        $manager = $this->container->get('persona.manager.manager_factory')->getWriteManager();

        $employee = $employeeRepository->find($id);
        if (!$employee) {
            throw new NotFoundHttpException(sprintf('Employee with id %s is not found.', $id));
        }

        if ($employeeHistoryRepository->isExisting($employee, $year, $month)) {
            $overtimeHistory = $employeeHistoryRepository->getExistingData();
        } else {
            $overtimeHistory = new OvertimeHistory();
        }

        $overtimeHistory->setEmployee($employee);
        $overtimeHistory->setOvertimeYear($year);
        $overtimeHistory->setOvertimeMonth($month);
        $overtimeHistory->setCalculatedValue($overtimeCalculator->calculate($date, $employee));

        $manager->persist($overtimeHistory);

        $manager->flush();

        return new JsonResponse(['status' => JsonResponse::HTTP_CREATED, 'message' => 'Employee overtime has been calculated']);
    }
}
