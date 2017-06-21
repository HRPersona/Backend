<?php

namespace Persona\Hris\Logger;

use Persona\Hris\Core\Logger\ExcludePathInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@bisnis.com>
 */
class ExcludePath implements ExcludePathInterface
{
    /**
     * @param string $path
     *
     * @return bool
     */
    public function isExclude(string $path): bool
    {
        if (strpos($path, 'login')) {
            return true;
        }

        if (strpos($path, 'logout')) {
            return true;
        }

        if (strpos($path, 'user-activities')) {
            return true;
        }

        return false;
    }
}
