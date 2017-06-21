<?php

namespace Persona\Hris\Core\Logger;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadata;
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
     * @param LoadClassMetadataEventArgs $eventArgs
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        /** @var ClassMetadata $classMetadata */
        $classMetadata = $eventArgs->getClassMetadata();
        if (null === $classMetadata->reflClass) {
            return;
        }

        if (!$classMetadata->reflClass->implementsInterface(ActionLoggerAwareInterface::class) && !in_array(ActionLoggerAwareTrait::class, $classMetadata->reflClass->getTraitNames())) {
            return;
        }

        foreach (['createdBy', 'updatedBy', 'deletedBy'] as $field) {
            if (!$classMetadata->hasField($field)) {
                $classMetadata->mapField([
                    'fieldName' => $field,
                    'type' => 'string',
                    'nullable' => true,
                ]);
            }
        }
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
        return [Events::loadClassMetadata, Events::prePersist, Events::preUpdate, Events::preRemove];
    }
}
