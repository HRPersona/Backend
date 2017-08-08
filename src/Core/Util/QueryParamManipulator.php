<?php

namespace Persona\Hris\Core\Util;

use Symfony\Component\HttpFoundation\Request;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class QueryParamManipulator
{
    /**
     * @param Request $request
     * @param string $paramKey
     */
    public static function manipulate(Request $request, string $paramKey): void
    {
        if (!$request->query->has($paramKey)) {
            $rawRequest = json_decode($request->getContent(), true);
            if (is_array($rawRequest) && array_key_exists($paramKey, $rawRequest)) {
                $request->query->set($paramKey, $rawRequest[$paramKey]);
            } else {
                $request->query->set($paramKey, $request->get($paramKey));
            }
        }
    }
}
