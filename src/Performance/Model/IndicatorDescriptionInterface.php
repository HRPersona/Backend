<?php

namespace Persona\Hris\Performance\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface IndicatorDescriptionInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return null|IndicatorInterface
     */
    public function getIndicator(): ? IndicatorInterface;

    /**
     * @param IndicatorInterface $indicator
     */
    public function setIndicator(IndicatorInterface $indicator = null): void;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @see IndicatorInterface consts
     *
     * @return int
     */
    public function getAppraisalValue(): int;
}
