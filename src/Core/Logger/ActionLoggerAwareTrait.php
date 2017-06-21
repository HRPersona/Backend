<?php

namespace Persona\Hris\Core\Logger;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
trait ActionLoggerAwareTrait
{
    /**
     * @var string
     */
    protected $createdBy;

    /**
     * @var string
     */
    protected $updatedBy;

    /**
     * @var string
     */
    protected $deletedBy;

    /**
     * Returns createdBy value.
     *
     * @return string
     */
    public function getCreatedBy(): string
    {
        return (string) $this->createdBy;
    }

    /**
     * Returns updatedBy value.
     *
     * @return string
     */
    public function getUpdatedBy(): string
    {
        return (string) $this->updatedBy;
    }

    /**
     * @param string $createdBy
     */
    public function setCreatedBy(string $createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @param string $updatedBy
     */
    public function setUpdatedBy(string $updatedBy)
    {
        $this->updatedBy = $updatedBy;
    }

    /**
     * @return string
     */
    public function getDeletedBy(): string
    {
        return (string) $this->deletedBy;
    }

    /**
     * @param string $deletedBy
     */
    public function setDeletedBy(string $deletedBy)
    {
        $this->deletedBy = $deletedBy;
    }
}
