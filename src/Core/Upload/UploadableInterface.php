<?php

namespace Persona\Hris\Core\Upload;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface UploadableInterface
{
    /**
     * @return null|string
     */
    public function getImageExtension(): ? string;

    /**
     * @param string $extension
     */
    public function setImageExtension(string $extension);

    /**
     * @return null|string
     */
    public function getImageString(): ? string;

    /**
     * @param string $image
     */
    public function setImageString(string $image);

    /**
     * @return string
     */
    public function getTargetField(): string;

    /**
     * @return string
     */
    public function getDirectoryPrefix(): string;
}
