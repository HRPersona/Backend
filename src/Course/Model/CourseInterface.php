<?php

namespace Persona\Hris\Course\Model;

use Persona\Hris\Performance\Model\IndicatorInterface;
use Persona\Hris\Share\Model\UniversityInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface CourseInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return null|string
     */
    public function getDescription(): ? string;

    /**
     * @return string
     */
    public function getMentor(): string;

    /**
     * @return \DateTime
     */
    public function getStartDate(): \DateTime;

    /**
     * @return \DateTime
     */
    public function getEndDate(): \DateTime;

    /**
     * @return null|IndicatorInterface
     */
    public function getIndicator(): ? IndicatorInterface;

    /**
     * @param IndicatorInterface|null $indicator
     */
    public function setIndicator(IndicatorInterface $indicator = null): void;

    /**
     * @return null|UniversityInterface
     */
    public function getUniversity(): ? UniversityInterface;

    /**
     * @param UniversityInterface $university
     */
    public function setUniversity(UniversityInterface $university = null): void;
}
