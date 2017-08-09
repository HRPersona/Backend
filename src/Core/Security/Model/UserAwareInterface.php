<?php

namespace Persona\Hris\Core\Security\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface UserAwareInterface
{
    /**
     * @return string
     */
    public function getUser(): string;

    /**
     * @param string|null $user
     */
    public function setUser(string $user = null);
}
