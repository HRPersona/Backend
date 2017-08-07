<?php

namespace Persona\Hris\Core\Logger;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\UnitOfWork;
use Persona\Hris\Core\Client\ClientInterface;
use Persona\Hris\Core\Client\ClientRepositoryInterface;
use Persona\Hris\Core\Manager\ManagerFactory;
use Persona\Hris\Core\Security\Model\UserInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class ActivityLogSubscriber implements EventSubscriber
{
    /**
     * @var ManagerFactory
     */
    private $managerFactory;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var ClientRepositoryInterface
     */
    private $clientRepository;

    /**
     * @var ActivityLoggerInterface
     */
    private $activityLogger;

    /**
     * @var ExcludeLoggerFactory
     */
    private $excludeLoggerFactory;

    /**
     * @var array
     */
    private $dataChanges = [];

    /**
     * @var array
     */
    private $identifier = [];

    /**
     * @var array
     */
    private $sourceTable = [];

    /**
     * @param ManagerFactory            $managerFactory
     * @param TokenStorageInterface     $tokenStorage
     * @param ClientRepositoryInterface $clientRepository
     * @param ExcludeLoggerFactory      $excludeLoggerFactory
     * @param string                    $activityLoggerClass
     */
    public function __construct(
        ManagerFactory $managerFactory,
        TokenStorageInterface $tokenStorage,
        ClientRepositoryInterface $clientRepository,
        ExcludeLoggerFactory $excludeLoggerFactory,
        string $activityLoggerClass
    ) {
        $this->managerFactory = $managerFactory;
        $this->tokenStorage = $tokenStorage;
        $this->clientRepository = $clientRepository;
        $this->excludeLoggerFactory = $excludeLoggerFactory;
        $this->activityLogger = new $activityLoggerClass();
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if (!$this->isValidEvent($event)) {
            return;
        }

        $this->activityLogger->setRemark($event->getException()->getMessage());
    }

    /**
     * @param PostResponseEvent $event
     */
    public function onKernelTerminate(PostResponseEvent $event)
    {
        if (!$this->isValidEvent($event)) {
            return;
        }

        $request = $event->getRequest();
        /** @var ClientInterface $client */
        $client = $this->clientRepository->findByApiKey($request->query->get('api_key'));

        if (!$client) {
            return;
        }

        $this->activityLogger->setClientName($client->getName());
        $this->activityLogger->setUsername($this->tokenStorage->getToken()->getUsername());
        $this->activityLogger->setPath($request->getPathInfo());
        $this->activityLogger->setRequest($request);
        $this->activityLogger->setMethod($request->getMethod());
        $this->activityLogger->setResponse($event->getResponse());
        $this->activityLogger->setIdentifier($this->identifier);
        $this->activityLogger->setSourceTable($this->sourceTable);
        $this->activityLogger->setDataChanges($this->dataChanges);

        $this->managerFactory->getWriteManager()->persist($this->activityLogger);
        $this->managerFactory->getWriteManager()->flush();
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function postPersist(LifecycleEventArgs $eventArgs)
    {
        $this->applyChangeSet($eventArgs);
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function postUpdate(LifecycleEventArgs $eventArgs)
    {
        $this->applyChangeSet($eventArgs);
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function postRemove(LifecycleEventArgs $eventArgs)
    {
        $this->applyChangeSet($eventArgs);
    }

    /**
     * @param KernelEvent $event
     *
     * @return bool
     */
    private function isValidEvent(KernelEvent $event)
    {
        $request = $event->getRequest();
        if ($this->excludeLoggerFactory->isExcludeLog($request->getPathInfo())) {
            return false;
        }

        if (!$event->isMasterRequest()) {
            return false;
        }

        if (!$this->tokenStorage->getToken()) {
            return false;
        }

        if (!$this->tokenStorage->getToken()->getUser() instanceof UserInterface) {
            return false;
        }

        return true;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    private function applyChangeSet(LifecycleEventArgs $eventArgs)
    {
        $manager = $eventArgs->getEntityManager();
        $entity = $eventArgs->getEntity();
        $metadata = $manager->getClassMetadata(get_class($entity));
        $unitOfWork = $manager->getUnitOfWork();

        $this->dataChanges = array_merge($this->dataChanges, [
            'table' => $metadata->getTableName(),
            'changes' => $this->calculateChangeSet($unitOfWork, $unitOfWork->getEntityChangeSet($entity)),
        ]);

        $this->identifier = array_merge($this->identifier, [$entity->getId()]);
        $this->sourceTable = array_merge($this->sourceTable, [$metadata->getTableName()]);
    }

    /**
     * @param UnitOfWork $unitOfWork
     * @param array      $changeSet
     *
     * @return array
     */
    private function calculateChangeSet(UnitOfWork $unitOfWork, array $changeSet)
    {
        $realChangeSet = [];
        foreach ($changeSet as $field => $item) {
            if (is_object($item[1]) && !$item[1] instanceof \DateTime) {
                $this->calculateChangeSet($unitOfWork, $unitOfWork->getEntityChangeSet($item[1]));
            } else {
                $realChangeSet[$field] = $item;
            }
        }

        return $realChangeSet;
    }

    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [Events::postPersist, Events::postUpdate, Events::postRemove];
    }
}
