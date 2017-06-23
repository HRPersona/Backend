<?php

namespace Persona\Hris\Repository;

use Doctrine\Common\Persistence\ObjectRepository;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
trait ParentAwareRepositoryTrait
{
    /**
     * @param ObjectRepository $entityRepository
     *
     * @return array
     */
    protected function getRoot(ObjectRepository $entityRepository)
    {
        return $entityRepository->findBy(['parent' => null]);
    }
}
