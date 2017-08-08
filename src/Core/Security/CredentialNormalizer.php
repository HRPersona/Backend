<?php

namespace Persona\Hris\Core\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class CredentialNormalizer
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
     * @param Request $request
     */
    public function normalize(Request $request): void
    {
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
}
