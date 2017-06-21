<?php

namespace Persona\Hris\Core\Client;

use Persona\Hris\Repository\CachableRepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface ClientRepositoryInterface extends CachableRepositoryInterface
{
    public function findByApiKey(string $apiKey);
}
