<?php

namespace Persona\Hris\Performance\Model;

use Persona\Hris\Repository\RepositoryInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
interface IndicatorRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $id
     *
     * @return IndicatorInterface|null
     */
    public function find(string $id): ? IndicatorInterface;
}
