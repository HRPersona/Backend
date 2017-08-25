<?php

namespace Persona\Hris\Organization\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface JobClassAwareInterface
{
    /**
     * @return string
     */
    public function getJobClassId(): string;

    /**
     * @param string|null $class
     */
    public function setJobClassId(string $class = null);

    /**
     * @return null|JobClassInterface
     */
    public function getJobClass(): ? JobClassInterface;

    /**
     * @param JobClassInterface|null $class
     */
    public function setJobClass(JobClassInterface $class = null): void;
}
