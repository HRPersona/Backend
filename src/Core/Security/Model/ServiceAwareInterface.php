<?php

namespace Persona\Hris\Core\Security\Model;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface ServiceAwareInterface
{
    /**
     * @return string
     */
    public function getServiceId(): string;

    /**
     * @param string|null $service
     */
    public function setServiceId(string $service = null);

    /**
     * @return null|ServiceInterface
     */
    public function getService(): ? ServiceInterface;

    /**
     * @param ServiceInterface|null $service
     */
    public function setService(ServiceInterface $service = null): void;
}
