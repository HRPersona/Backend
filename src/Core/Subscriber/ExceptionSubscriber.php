<?php

namespace Persona\Hris\Core\Subscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class ExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param SerializerInterface $serializer
     * @param LoggerInterface     $logger
     */
    public function __construct(SerializerInterface $serializer, LoggerInterface $logger)
    {
        $this->serializer = $serializer;
        $this->logger = $logger;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $request = $event->getRequest();
        $exception = $event->getException();

        if ($exception instanceof HttpExceptionInterface) {
            return;
        }

        $this->logger->error(sprintf('Message: %s => Trace: %s', $exception->getMessage(), $exception->getTraceAsString()));
        if ('html' === $request->getRequestFormat()) {
            return;
        }

        $response = new Response();
        $response->setContent($this->serializer->serialize([
            'file' => $exception->getFile(),
            'message' => $exception->getMessage(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString(),
        ], $request->getRequestFormat()));
        $response->setStatusCode(Response::HTTP_EXPECTATION_FAILED);

        $event->setResponse($response);
        $event->stopPropagation();
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException', -17],
        ];
    }
}
