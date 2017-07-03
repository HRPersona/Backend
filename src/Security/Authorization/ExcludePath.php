<?php

namespace Persona\Hris\Security\Authorization;

use Persona\Hris\Core\Security\Authorization\ExcludePathInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
class ExcludePath implements ExcludePathInterface
{
    /**
     * @var Request
     */
    private $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    public function isExclude(string $path): bool
    {
        if (preg_match('/^\/(api\/(doc|login*|logout*|change-password*|username\/generate*|files\/*|users\/me))/', $path)) {
            return true;
        }

        if (false !== strpos($path, '/users/update-profile') && 'put' === strtolower($this->request->getMethod())) {
            return true;
        }

        if (false !== strpos($path, '/roles') && 'get' === strtolower($this->request->getMethod()) && $this->request->query->has('user_id')) {
            return true;
        }

        return false;
    }
}
