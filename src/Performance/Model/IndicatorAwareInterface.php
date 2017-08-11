<?php

namespace Persona\Hris\Performance\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface IndicatorAwareInterface
{
    /**
     * @return string
     */
    public function getIndicatorId(): string;

    /**
     * @param string|null $indicator
     */
    public function setIndicatorId(string $indicator = null);

    /**
     * @return null|IndicatorInterface
     */
    public function getIndicator(): ? IndicatorInterface;

    /**
     * @param IndicatorInterface|null $indicator
     */
    public function setIndicator(IndicatorInterface $indicator = null): void;
}
