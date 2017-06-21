<?php

namespace Persona\Hris\Share\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface CityInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return null|ProvinceInterface
     */
    public function getProvince(): ? ProvinceInterface;

    /**
     * @param ProvinceInterface $province
     */
    public function setProvince(ProvinceInterface $province): void;

    /**
     * @return string
     */
    public function getCode(): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getPostalCode(): string;
}
