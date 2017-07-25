<?php

namespace Persona\Hris\Salary\Subscriber;

use Persona\Hris\Salary\Model\PayrollInterface;
use Persona\Hris\Salary\Model\PayrollRepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class PreventReopenPayrollSubscriber implements EventSubscriberInterface
{
    /**
     * @var PayrollRepositoryInterface
     */
    private $payrollRepository;

    /**
     * @param PayrollRepositoryInterface $payrollRepository
     */
    public function __construct(PayrollRepositoryInterface $payrollRepository)
    {
        $this->payrollRepository = $payrollRepository;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $requestData = $event->getRequest()->attributes->get('data');
        if ($requestData instanceof PayrollInterface) {
            $persistence = $this->payrollRepository->find($requestData->getId());
            if ($persistence->isClosed() && !$requestData->isClosed()) {
                throw new NotAcceptableHttpException(sprintf('Can not reopen closed payroll.'));
            }
        }
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 0],
        ];
    }
}
