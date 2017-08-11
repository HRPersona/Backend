<?php

namespace Persona\Hris\Share\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface PlaceOfBirthAwareInterface
{
    /**
     * @return string
     */
    public function getPlaceOfBirthId(): string;

    /**
     * @param string|null $city
     */
    public function setPlaceOfBirthId(string $city = null);

    /**
     * @return null|CityInterface
     */
    public function getPlaceOfBirth(): ? CityInterface;

    /**
     * @param CityInterface|null $city
     */
    public function setPlaceOfBirth(CityInterface $city = null): void;
}
