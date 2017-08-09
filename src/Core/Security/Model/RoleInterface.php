<?php

namespace Persona\Hris\Core\Security\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface RoleInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @param string $user
     */
    public function setUser(string $user = null);

    /**
     * @return string
     */
    public function getUser(): string;

    /**
     * @param ModuleInterface $module
     */
    public function setModule(ModuleInterface $module): void;

    /**
     * @return ModuleInterface
     */
    public function getModule(): ? ModuleInterface;

    /**
     * @param bool $addable
     */
    public function setAddable(bool $addable);

    /**
     * @return bool
     */
    public function getAddable(): bool;

    /**
     * @param bool $editable
     */
    public function setEditable(bool $editable);

    /**
     * @return bool
     */
    public function getEditable(): bool;

    /**
     * @param bool $viewable
     */
    public function setViewable(bool $viewable);

    /**
     * @return bool
     */
    public function getViewable(): bool;

    /**
     * @param bool $deletable
     */
    public function setDeletable(bool $deletable);

    /**
     * @return bool
     */
    public function getDeletable(): bool;
}
