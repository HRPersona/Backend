<?php

namespace Persona\Hris\Core\Logger;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface ExcludePathInterface
{
    /**
     * @param string $path
     *
     * @return bool
     */
    public function isExclude(string $path): bool;
}
