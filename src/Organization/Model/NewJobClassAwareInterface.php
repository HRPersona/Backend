<?php

namespace Persona\Hris\Organization\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface NewJobClassAwareInterface
{
    /**
     * @return string
     */
    public function getNewJobClassId(): string;

    /**
     * @param string|null $class
     */
    public function setNewJobClassId(string $class = null);

    /**
     * @return null|JobClassInterface
     */
    public function getNewJobClass(): ? JobClassInterface;

    /**
     * @param JobClassInterface|null $class
     */
    public function setNewJobClass(JobClassInterface $class = null): void;
}
