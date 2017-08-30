<?php

namespace Persona\Hris\Performance\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadata;
use Persona\Hris\Performance\AppraisalAwareTrait;
use Persona\Hris\Performance\Model\AppraisalAwareInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class AppraisalAwareSubscriber implements EventSubscriber
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

        if (!$classMetadata->reflClass->implementsInterface(AppraisalAwareInterface::class) && !in_array(AppraisalAwareTrait::class, $classMetadata->reflClass->getTraitNames())) {
            return;
        }

        foreach ([
            'firstSupervisorAppraisalById',
            'secondSupervisorAppraisalById',
            'selfAppraisalComment',
            'firstSupervisorAppraisalComment',
            'secondSupervisorAppraisalComment',
        ] as $field) {
            if (!$classMetadata->hasField($field)) {
                $classMetadata->mapField([
                    'fieldName' => $field,
                    'type' => 'string',
                    'nullable' => true,
                ]);
            }
        }

        foreach ([
            'selfAppraisal',
            'firstSupervisorAppraisal',
            'secondSupervisorAppraisal',
        ] as $field) {
            if (!$classMetadata->hasField($field)) {
                $classMetadata->mapField([
                    'fieldName' => $field,
                    'type' => 'smallint',
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
