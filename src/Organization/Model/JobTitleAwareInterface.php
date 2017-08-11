<?php

namespace Persona\Hris\Organization\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface JobTitleAwareInterface
{
    /**
     * @return string
     */
    public function getJobTitleId(): string;

    /**
     * @param string|null $jobTitle
     */
    public function setJobTitleId(string $jobTitle = null);

    /**
     * @return null|JobTitleInterface
     */
    public function getJobTitle(): ? JobTitleInterface;

    /**
     * @param JobTitleInterface|null $jobTitle
     */
    public function setJobTitle(JobTitleInterface $jobTitle = null): void;
}
