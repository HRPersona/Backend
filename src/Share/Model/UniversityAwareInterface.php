<?php

namespace Persona\Hris\Share\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface UniversityAwareInterface
{
    /**
     * @return string
     */
    public function getUniversityId(): string;

    /**
     * @param string|null $university
     */
    public function setUniversityId(string $university = null);

    /**
     * @return null|UniversityInterface
     */
    public function getUniversity(): ? UniversityInterface;

    /**
     * @param UniversityInterface|null $university
     */
    public function setUniversity(UniversityInterface $university = null): void;
}
