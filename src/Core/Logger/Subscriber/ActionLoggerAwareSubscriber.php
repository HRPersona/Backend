<?php

namespace Persona\Hris\Core\Logger\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadata;
use Persona\Hris\Core\Logger\ActionLoggerAwareTrait;
use Persona\Hris\Core\Logger\Model\ActionLoggerAwareInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class ActionLoggerAwareSubscriber implements EventSubscriber
{
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
     * @return array
     */
    public function getSubscribedEvents(): array
    {
        return [Events::loadClassMetadata];
    }
}
