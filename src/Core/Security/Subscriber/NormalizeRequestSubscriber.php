<?php

namespace Persona\Hris\Core\Security\Subscriber;

use Persona\Hris\Core\Security\CredentialDumper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\Serializer;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class NormalizeRequestSubscriber implements EventSubscriberInterface
{
    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @param Serializer $serializer
     */
    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
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

        $tokenKey = 'access_token';
        if (!$request->query->has($tokenKey)) {
            $rawRequest = json_decode($request->getContent(), true);
            if (is_array($rawRequest) && array_key_exists($tokenKey, $rawRequest)) {
                $request->query->set($tokenKey, $rawRequest[$tokenKey]);
            } else {
                $request->query->set($tokenKey, $request->get($tokenKey));
            }
        }

        if ('form' === $request->getContentType()) {
            return;
        }

        $uri = $request->getPathInfo();
        if (false !== strpos($uri, '/api/login') && !empty($content = $request->getContent())) {
            /** @var CredentialDumper $credential */
            $credential = $this->serializer->deserialize($content, CredentialDumper::class, $request->getRequestFormat('json'));
            $request->request->set('username', $credential->getUsername()); //username is the value of username_parameter in security.yml
            $request->request->set('password', $credential->getPassword()); //password is the value of password_parameter in security.yml
        }
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
