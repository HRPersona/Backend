<?php

namespace Persona\Hris\Organization\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface OldJobClassAwareInterface
{
    /**
     * @return string
     */
    public function getOldJobClassId(): string;

    /**
     * @param string|null $class
     */
    public function setOldJobClassId(string $class = null);

    /**
     * @return null|JobClassInterface
     */
    public function getOldJobClass(): ? JobClassInterface;

    /**
     * @param JobClassInterface|null $class
     */
    public function setOldJobClass(JobClassInterface $class = null): void;
}
