<?php

namespace Persona\Hris\Core\Client;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Persona\Hris\Core\Security\Model\UserInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class ApiKeyGeneratorSubscriber implements EventSubscriber
{
    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if (!$entity instanceof ClientInterface) {
            return;
        }

        $this->checkUserRelation($entity);
        $entity->setApiKey(sha1(sprintf('%s_%s_%s', date('YmdHis'), $entity->getName(), $entity->getEmail())));
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if (!$entity instanceof ClientInterface) {
            return;
        }

        $this->checkUserRelation($entity);
    }

    /**
     * @param ClientInterface $entity
     */
    private function checkUserRelation(ClientInterface $entity)
    {
        if ($entity->getUser() instanceof UserInterface && $email = $entity->getUser()->getEmail()) {
            $entity->setEmail($email);
        }
    }

    /**
     * @return array
     */
    public function getSubscribedEvents(): array
    {
        return [Events::prePersist, Events::preUpdate];
    }
}
