<?php

namespace Persona\Hris\Core\Security\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface ModuleAwareInterface
{
    /**
     * @return string
     */
    public function getModuleId(): string;

    /**
     * @param string|null $module
     */
    public function setModuleId(string $module = null);

    /**
     * @return null|ModuleInterface
     */
    public function getModule(): ? ModuleInterface;

    /**
     * @param ModuleInterface|null $module
     */
    public function setModule(ModuleInterface $module = null): void;
}
