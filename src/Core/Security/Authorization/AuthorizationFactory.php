<?php

namespace Persona\Hris\Core\Security\Authorization;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class AuthorizationFactory
{
    /**
     * @var ExcludePathInterface[]
     */
    private $excludePaths;

    /**
     * @param array $excludePaths
     */
    public function __construct(array $excludePaths = [])
    {
        $this->excludePaths = $excludePaths;
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    public function isExcludeAuthorization(string $path): bool
    {
        foreach ($this->excludePaths as $excludeAuthorizationPath) {
            if ($excludeAuthorizationPath->isExclude($path)) {
                return true;
            }
        }

        return false;
    }
}
