<?php

namespace Persona\Hris\Core\Logger\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Persona\Hris\Core\Logger\Model\ActionLoggerAwareInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class ActionLoggerSubscriber implements EventSubscriber
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if (!$entity instanceof ActionLoggerAwareInterface) {
            return;
        }

        $this->updateActionLog($entity);
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if (!$entity instanceof ActionLoggerAwareInterface) {
            return;
        }

        $this->updateActionLog($entity);
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preRemove(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if (!$entity instanceof ActionLoggerAwareInterface) {
            return;
        }

        if (!$token = $this->tokenStorage->getToken()) {
            throw new AccessDeniedHttpException();
        }

        $entity->setDeletedBy($token->getUsername());
    }

    /**
     * @param ActionLoggerAwareInterface $loggable
     */
    private function updateActionLog(ActionLoggerAwareInterface $loggable)
    {
        if (!$token = $this->tokenStorage->getToken()) {
            $username = 'SYSTEM';
        } else {
            $username = $token->getUsername();
        }

        if (!$loggable->getCreatedBy()) {
            $loggable->setCreatedBy($username);
        }

        $loggable->setUpdatedBy($username);
    }

    /**
     * @return array
     */
    public function getSubscribedEvents(): array
    {
        return [Events::prePersist, Events::preUpdate, Events::preRemove];
    }
}
