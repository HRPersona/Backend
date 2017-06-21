<?php

namespace Persona\Hris\Core\Security\Authorization;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
class ExcludeProfilerPath implements ExcludePathInterface
{
    /**
     * @param string $path
     *
     * @return bool
     */
    public function isExclude(string $path): bool
    {
        if (preg_match('/^\/(_(profiler|wdt))\//', $path)) {
            return true;
        }

        return false;
    }
}
