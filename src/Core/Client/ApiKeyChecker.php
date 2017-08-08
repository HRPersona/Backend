<?php

namespace Persona\Hris\Core\Client;

use Persona\Hris\Core\Util\QueryParamManipulator;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class ApiKeyChecker
{
    const APIKEY_PARAMETER = 'api_key';

    /**
     * @var ClientRepositoryInterface
     */
    private $clientRepository;

    /**
     * @param ClientRepositoryInterface $clientRepository
     */
    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    public function isValid(Request $request): bool
    {
        $uri = $request->getPathInfo();
        if (preg_match('/api\//i', $uri)) {
            QueryParamManipulator::manipulate($request, self::APIKEY_PARAMETER);

            if (null === $request->query->get(self::APIKEY_PARAMETER)) {
                return false;
            }

            if (!$this->clientRepository->findByApiKey($request->query->get(self::APIKEY_PARAMETER)) instanceof ClientInterface) {
                return false;
            }

            return true;
        }

        return true;
    }
}
