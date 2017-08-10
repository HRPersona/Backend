<?php

namespace Persona\Hris\Core\Logger\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface ActionLoggerAwareInterface
{
    /**
     * @param string $username
     */
    public function setCreatedBy(string $username);

    /**
     * @param string $username
     */
    public function setUpdatedBy(string $username);

    /**
     * @param string $username
     */
    public function setDeletedBy(string $username);

    /**
     * @return string
     */
    public function getCreatedBy(): string;

    /**
     * @return string
     */
    public function getUpdatedBy(): string;

    /**
     * @return string
     */
    public function getDeletedBy(): string;
}
