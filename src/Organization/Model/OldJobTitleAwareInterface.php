<?php

namespace Persona\Hris\Organization\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface OldJobTitleAwareInterface
{
    /**
     * @return string
     */
    public function getOldJobTitleId(): string;

    /**
     * @param string|null $jobTitle
     */
    public function setOldJobTitleId(string $jobTitle = null);

    /**
     * @return null|JobTitleInterface
     */
    public function getOldJobTitle(): ? JobTitleInterface;

    /**
     * @param JobTitleInterface|null $jobTitle
     */
    public function setOldJobTitle(JobTitleInterface $jobTitle = null): void;
}
