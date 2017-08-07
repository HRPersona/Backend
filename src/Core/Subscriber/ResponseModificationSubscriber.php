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
final class ResponseModificationSubscriber implements EventSubscriberInterface
{
    /**
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $event->getResponse()->headers->set('X-Backend', gethostbyname(php_uname('n')));
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => ['onKernelResponse', 7],
        ];
    }
}
