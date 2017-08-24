<?php

namespace Persona\Hris;

use Persona\Hris\Core\Operation\PathResolverException;
use Persona\Hris\Core\Operation\PathResolverInterface;
use Persona\Hris\Core\Util\StringUtil;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@bisnis.com>
 */
final class PathResolver implements PathResolverInterface
{
    /**
     * @param string $resourceShortName
     *
     * @throws PathResolverException
     *
     * @return string
     */
    public function getModuleAlias(string $resourceShortName): string
    {
        return implode('/', explode('-', StringUtil::dash($resourceShortName)));
    }
}
