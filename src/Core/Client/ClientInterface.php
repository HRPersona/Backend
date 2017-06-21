<?php

namespace Persona\Hris\Core\Client;

use Persona\Hris\Core\Security\Model\UserInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface ClientInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     */
    public function setName(string $name);

    /**
     * @return string
     */
    public function getEmail(): string;

    /**
     * @param string $email
     */
    public function setEmail(string $email);

    /**
     * @return string
     */
    public function getApiKey(): ? string;

    /**
     * @param string $apiKey
     */
    public function setApiKey(string $apiKey);

    /**
     * @return UserInterface|null
     */
    public function getUser():? UserInterface;
}
