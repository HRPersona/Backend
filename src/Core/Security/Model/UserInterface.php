<?php

namespace Persona\Hris\Core\Security\Model;

use FOS\UserBundle\Model\UserInterface as BaseUser;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface UserInterface extends BaseUser
{
    const SESSION_KEY = '__TOKEN__';

    /**
     * @return string
     */
    public function getFullName(): string;

    /**
     * @param string $fullName
     */
    public function setFullName(string $fullName);

    /**
     * @param UserInterface $user
     *
     * @return bool
     */
    public function isMe(UserInterface $user): bool;

    /**
     * @param bool $loggedIn
     */
    public function setLoggedIn(bool $loggedIn);

    /**
     * @param UserInterface    $user
     * @param SessionInterface $session
     *
     * @return bool
     */
    public function isLoggedIn(UserInterface $user, SessionInterface $session): bool;

    /**
     * @param string $sessionId
     */
    public function setSessionId(string $sessionId);

    /**
     * @return string
     */
    public function getSessionId(): string;
}
