<?php

namespace Persona\Hris\Core\Security\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface ModuleInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @param string $name
     */
    public function setName(string $name);

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getGroupName(): string;

    /**
     * @param string $group
     */
    public function setGroupName(string $group);

    /**
     * @return int
     */
    public function getMenuOrder(): int;

    /**
     * @param int $menuOrder
     */
    public function setMenuOrder(int $menuOrder);

    /**
     * @return bool
     */
    public function isMenuDisplay(): bool;

    /**
     * @param bool $menuDisplay
     */
    public function setMenuDisplay(bool $menuDisplay);

    /**
     * @return string
     */
    public function getDescription(): ? string;

    /**
     * @param string $iconCls
     */
    public function setIconCls(string $iconCls);

    /**
     * @return string
     */
    public function getIconCls(): string;

    /**
     * @param string $path
     */
    public function setPath(string $path);

    /**
     * @return string
     */
    public function getPath(): string;
}
