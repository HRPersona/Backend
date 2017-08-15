<?php

namespace Persona\Hris\Organization\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface NewJobTitleAwareInterface
{
    /**
     * @return string
     */
    public function getNewJobTitleId(): string;

    /**
     * @param string|null $jobTitle
     */
    public function setNewJobTitleId(string $jobTitle = null);

    /**
     * @return null|JobTitleInterface
     */
    public function getNewJobTitle(): ? JobTitleInterface;

    /**
     * @param JobTitleInterface|null $jobTitle
     */
    public function setNewJobTitle(JobTitleInterface $jobTitle = null): void;
}
