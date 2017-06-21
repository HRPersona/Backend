<?php

namespace Persona\Hris\Core\Operation;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface PathResolverInterface
{
    /**
     * @param string $moduleShortName
     *
     * @throws PathResolverException
     *
     * @return string
     */
    public function getModuleAlias(string $moduleShortName): string;
}
