<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Core\Client\ClientInterface;
use Persona\Hris\Core\Client\ClientRepositoryInterface;
use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Repository\AbstractCachableRepository;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class ClientRepository extends AbstractCachableRepository implements ClientRepositoryInterface
{
    /**
     * @var string
     */
    private $class;

    /**
     * @param ManagerFactory $managerFactory
     * @param string         $class
     */
    public function __construct(ManagerFactory $managerFactory, string  $class)
    {
        parent::__construct($managerFactory);
        $this->class = $class;
    }

    /**
     * @param string $apiKey
     *
     * @return ClientInterface|null
     */
    public function findByApiKey(string $apiKey)
    {
        $cache = $this->getCacheDriver();
        $cacheId = sprintf('%s_%s', $this->class, $apiKey);
        if ($cache->contains($cacheId)) {
            $data = $cache->fetch($cacheId);
            $this->managerFactory->merge([$data]);
        } else {
            $data = $this->managerFactory->getReadManager()->getRepository($this->class)->findOneBy(['apiKey' => $apiKey, 'deletedAt' => null]);
            $cache->save($cacheId, $data, $this->getCacheLifetime());
        }

        return $data;
    }
}
