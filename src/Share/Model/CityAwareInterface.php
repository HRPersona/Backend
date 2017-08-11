<?php

namespace Persona\Hris\Share\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface CityAwareInterface
{
    /**
     * @return string
     */
    public function getCityId(): string;

    /**
     * @param string|null $city
     */
    public function setCityId(string $city = null);

    /**
     * @return null|CityInterface
     */
    public function getCity(): ? CityInterface;

    /**
     * @param CityInterface|null $city
     */
    public function setCity(CityInterface $city = null): void;
}
