<?php

namespace Persona\Hris\Core\Security\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Persona\Hris\Core\Security\Model\UserInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class DefaultPasswordSubscriber implements EventSubscriber
{
    /**
     * @var string
     */
    private $defaultPassword;

    /**
     * @param string $defaultPassword
     */
    public function __construct(string $defaultPassword)
    {
        $this->defaultPassword = $defaultPassword;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if (!$entity instanceof UserInterface) {
            return;
        }

        $password = $entity->getPlainPassword() ?: $this->defaultPassword;
        $entity->setPlainPassword($password);
    }

    /**
     * @return array
     */
    public function getSubscribedEvents(): array
    {
        return [Events::prePersist];
    }
}
