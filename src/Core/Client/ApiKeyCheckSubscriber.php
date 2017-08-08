<?php

namespace Persona\Hris\Core\Client;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class ApiKeyCheckSubscriber implements EventSubscriberInterface
{
    /**
     * @var ApiKeyChecker
     */
    private $apiKeyChecker;

    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * @param ApiKeyChecker $apiKeyChecker
     * @param KernelInterface           $kernel
     */
    public function __construct(ApiKeyChecker $apiKeyChecker, KernelInterface $kernel)
    {
        $this->apiKeyChecker = $apiKeyChecker;
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

        if (!$this->apiKeyChecker->isValid($event->getRequest())) {
            throw new AccessDeniedException(sprintf('Please provide valid Api Key.'));
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
