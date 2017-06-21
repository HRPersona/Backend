<?php

namespace Persona\Hris\Core\Upload;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class UploadSubscriber implements EventSubscriber
{
    /**
     * @var Uploader
     */
    private $uploader;

    /**
     * @param Uploader $uploader
     */
    public function __construct(Uploader $uploader)
    {
        $this->uploader = $uploader;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $this->upload($eventArgs);
    }

    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $this->upload($eventArgs);
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    private function upload(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        if ($entity instanceof UploadableInterface) {
            $this->uploader->upload($entity);
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
