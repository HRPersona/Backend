<?php

namespace Persona\Hris\Core\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class ResponseCacheSubscriber implements EventSubscriberInterface
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var int
     */
    private $cacheLifetime;

    /**
     * @param KernelInterface       $kernel
     * @param TokenStorageInterface $tokenStorage
     * @param int                   $cacheLifetime
     */
    public function __construct(KernelInterface $kernel, TokenStorageInterface $tokenStorage, int $cacheLifetime = 0)
    {
        $this->kernel = $kernel;
        $this->tokenStorage = $tokenStorage;
        $this->cacheLifetime = $cacheLifetime;
    }

    /**
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $request = $event->getRequest();
        $response = $event->getResponse();

        if ($request->isMethod('GET')) {
            $key = __CLASS__;
            if ($token = $this->tokenStorage->getToken()) {
                $key = $token->getUsername();
            }

            $response->setSharedMaxAge($this->cacheLifetime);
            $response->setEtag(sha1(sprintf('%s:%s', $key, $response->getContent())));
        }

        $response->headers->set('X-Backend', gethostbyname(php_uname('n')));
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => ['onKernelResponse', 17],
        ];
    }
}
