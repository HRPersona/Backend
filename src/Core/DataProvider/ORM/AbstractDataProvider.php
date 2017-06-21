<?php

namespace Persona\Hris\Core\DataProvider\ORM;

use Doctrine\ORM\QueryBuilder;
use Knp\DoctrineBehaviors\Model\SoftDeletable\SoftDeletable;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
class AbstractDataProvider
{
    /**
     * @param QueryBuilder $queryBuilder
     * @param string       $resourceClass
     *
     * @return QueryBuilder
     */
    protected function filterSoftDeletable(QueryBuilder $queryBuilder, string $resourceClass)
    {
        $reflection = new \ReflectionClass($resourceClass);
        if (in_array(SoftDeletable::class, $reflection->getTraitNames())) {
            $queryBuilder->andWhere($queryBuilder->expr()->isNull('o.deletedAt'));
        }

        return $queryBuilder;
    }
}
