<?php

namespace Persona\Hris\Core\Client;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class ApiKeyCheckSubscriber implements EventSubscriberInterface
{
    /**
     * @var ClientRepositoryInterface
     */
    private $repository;

    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * @param ClientRepositoryInterface $clientRepository
     * @param KernelInterface           $kernel
     */
    public function __construct(ClientRepositoryInterface $clientRepository, KernelInterface $kernel)
    {
        $this->repository = $clientRepository;
        $this->kernel = $kernel;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest() || 'prod' !== strtolower($this->kernel->getEnvironment())) {
            return;
        }

        $request = $event->getRequest();
        $uri = $request->getPathInfo();
        if (preg_match('/api\//i', $uri)) {
            $apiKey = 'api_key';
            if (!$request->query->has($apiKey)) {
                $rawRequest = json_decode($request->getContent(), true);
                if (is_array($rawRequest) && array_key_exists($apiKey, $rawRequest)) {
                    $request->query->set($apiKey, $rawRequest[$apiKey]);
                } else {
                    $request->query->set($apiKey, $request->get($apiKey));
                }
            }

            if (null === $request->query->get($apiKey)) {
                throw new UnauthorizedHttpException(sprintf('Client not found. Please correct your API Key.'));
            }

            if (!$this->repository->findByApiKey($request->query->get($apiKey)) instanceof ClientInterface) {
                throw new UnauthorizedHttpException(sprintf('Client not found. Please correct your API Key.'));
            }
        }
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 27],
        ];
    }
}
