<?php

namespace Persona\Hris\Core\Security\Authorization;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
class ExcludeWebAssetPath implements ExcludePathInterface
{
    /**
     * @param string $path
     *
     * @return bool
     */
    public function isExclude(string $path): bool
    {
        if (preg_match('/^\/(css|images|js|img|bundles)\//', $path) || preg_match('/^\.(css|js|jpg|jpeg|png)$/', $path)) {
            return true;
        }

        return false;
    }
}
