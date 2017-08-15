<?php

namespace Persona\Hris\Leave\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface LeaveAwareInterface
{
    /**
     * @return string
     */
    public function getLeaveId(): string;

    /**
     * @param string|null $leave
     */
    public function setLeaveId(string $leave = null);

    /**
     * @return null|LeaveInterface
     */
    public function getLeave(): ? LeaveInterface;

    /**
     * @param LeaveInterface|null $leave
     */
    public function setLeave(LeaveInterface $leave = null): void;
}
