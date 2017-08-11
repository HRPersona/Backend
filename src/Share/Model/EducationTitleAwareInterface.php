<?php

namespace Persona\Hris\Share\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface EducationTitleAwareInterface
{
    /**
     * @return string
     */
    public function getEducationTitleId(): string;

    /**
     * @param string|null $educationTitle
     */
    public function setEducationTitleId(string $educationTitle = null);

    /**
     * @return null|EducationTitleInterface
     */
    public function getEducationTitle(): ? EducationTitleInterface;

    /**
     * @param EducationTitleInterface|null $educationTitle
     */
    public function setEducationTitle(EducationTitleInterface $educationTitle = null): void;
}
