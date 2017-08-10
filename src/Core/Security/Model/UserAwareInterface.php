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
    public function getUserId(): string;

    /**
     * @param string|null $user
     */
    public function setUserId(string $user = null);

    /**
     * @return null|UserInterface
     */
    public function getUser(): ? UserInterface;

    /**
     * @param UserInterface|null $user
     */
    public function setUser(UserInterface $user = null): void;
}
