<?php

namespace Persona\Hris;

use Persona\Hris\Core\Operation\PathResolverException;
use Persona\Hris\Core\Operation\PathResolverInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@bisnis.com>
 */
final class PathResolver implements PathResolverInterface
{
    /**
     * @param string $moduleShortName
     *
     * @throws PathResolverException
     *
     * @return string
     */
    public function getModuleAlias(string $moduleShortName): string
    {
        if ('employee' === $moduleShortName) {
            return $moduleShortName;
        } else {
            throw new PathResolverException();
        }
    }
}
