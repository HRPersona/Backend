<?php

namespace Persona\Hris\Allocation\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface ResignReasonAwareInterface
{
    /**
     * @return string
     */
    public function getResignReasonId(): string;

    /**
     * @param string|null $resignReason
     */
    public function setResignReasonId(string $resignReason = null);

    /**
     * @return null|ResignReasonInterface
     */
    public function getResignReason(): ? ResignReasonInterface;

    /**
     * @param ResignReasonInterface|null $resignReason
     */
    public function setResignReason(ResignReasonInterface $resignReason = null): void;
}
