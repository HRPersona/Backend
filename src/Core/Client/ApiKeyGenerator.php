<?php

namespace Persona\Hris\Core\Client;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
class ApiKeyGenerator
{
    /**
     * @param ClientInterface $client
     *
     * @return string
     */
    public static function generate(ClientInterface $client): string
    {
        return sha1(sprintf('%s_%s_%s', date('YmdHis'), $client->getName(), $client->getEmail()));
    }
}
