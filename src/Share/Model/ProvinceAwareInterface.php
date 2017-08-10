<?php

namespace Persona\Hris\Share\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface ProvinceAwareInterface
{
    /**
     * @return string
     */
    public function getProvinceId(): string;

    /**
     * @param string|null $module
     */
    public function setProvinceId(string $module = null);

    /**
     * @return null|ProvinceInterface
     */
    public function getProvince(): ? ProvinceInterface;

    /**
     * @param ProvinceInterface|null $module
     */
    public function setProvince(ProvinceInterface $module = null): void;
}
