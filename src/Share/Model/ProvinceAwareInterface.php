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
     * @param string|null $province
     */
    public function setProvinceId(string $province = null);

    /**
     * @return null|ProvinceInterface
     */
    public function getProvince(): ? ProvinceInterface;

    /**
     * @param ProvinceInterface|null $province
     */
    public function setProvince(ProvinceInterface $province = null): void;
}
