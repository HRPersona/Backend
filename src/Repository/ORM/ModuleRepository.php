<?php

namespace Persona\Hris\Repository\ORM;

use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Core\Security\Model\ModuleInterface;
use Persona\Hris\Core\Security\Model\ModuleRepositoryInterface;
use Persona\Hris\Repository\AbstractCachableRepository;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@bisnis.com>
 */
final class ModuleRepository extends AbstractCachableRepository implements ModuleRepositoryInterface
{
    /**
     * @var string
     */
    private $class;

    /**
     * @var bool
     */
    private $recall;

    /**
     * @param ManagerFactory $managerFactory
     * @param string         $class
     */
    public function __construct(ManagerFactory $managerFactory, string  $class)
    {
        parent::__construct($managerFactory);
        $this->class = $class;
        $this->recall = true;
    }

    /**
     * @param string $path
     *
     * @return ModuleInterface|null
     */
    public function findByPath(string $path): ? ModuleInterface
    {
        $cache = $this->getCacheDriver();
        $cacheId = sprintf('%s_%s', $this->class, $path);
        if ($cache->contains($cacheId)) {
            $data = $cache->fetch($cacheId);
            $this->managerFactory->merge([$data]);
        } else {
            $data = $this->managerFactory->getReadManager()->getRepository($this->class)->findOneBy(['path' => $path, 'deletedAt' => null]);
            if (!$data && $this->recall) {
                $path = explode('/', $path);
                array_pop($path);
                $this->recall = false;

                $data = $this->findByPath(implode('/', $path));
            } else {
                $cache->save($cacheId, $data, $this->getCacheLifetime());
            }
        }

        return $data;
    }
}
