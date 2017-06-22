<?php

namespace Persona\Hris\Performance\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface IndicatorInterface
{
    const VALUE_EXCELLENT = 5;
    const VALUE_VERY_GOOD = 4;
    const VALUE_GOOD = 3;
    const VALUE_FAIR = 2;
    const VALUE_POOR = 1;

    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return string
     */
    public function getCode(): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return int
     */
    public function getMinimalValue(): int;
}
