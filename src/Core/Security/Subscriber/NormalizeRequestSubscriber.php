<?php

namespace Persona\Hris\Core\Security\Subscriber;

use Persona\Hris\Core\Security\CredentialDumper;
use Persona\Hris\Core\Security\CredentialNormalizer;
use Persona\Hris\Core\Util\QueryParamManipulator;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\Serializer;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class NormalizeRequestSubscriber implements EventSubscriberInterface
{
    const TOKENKEY_PARAMETER = 'access_token';

    /**
     * @var CredentialNormalizer
     */
    private $credentialNormazer;

    /**
     * @param CredentialNormalizer $credentialNormalizer
     */
    public function __construct(CredentialNormalizer $credentialNormalizer)
    {
        $this->credentialNormazer = $credentialNormalizer;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();
        QueryParamManipulator::manipulate($request, self::TOKENKEY_PARAMETER);
        $this->credentialNormazer->normalize($request);
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 17],
        ];
    }
}
