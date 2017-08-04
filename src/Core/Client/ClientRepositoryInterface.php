<?php

namespace Persona\Hris\Core\Client;

use Persona\Hris\Repository\RepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface ClientRepositoryInterface extends RepositoryInterface
{
    public function findByApiKey(string $apiKey);
}
