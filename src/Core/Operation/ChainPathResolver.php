<?php

namespace Persona\Hris\Core\Operation;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class ChainPathResolver implements PathResolverInterface
{
    /**
     * @var PathResolverInterface[]
     */
    private $pathResolvers;

    /**
     * @param array $pathResolvers
     */
    public function __construct(array $pathResolvers)
    {
        $this->pathResolvers = $pathResolvers;
    }

    /**
     * @param string $resourceShortName
     *
     * @throws PathResolverException
     *
     * @return string
     */
    public function getModuleAlias(string $resourceShortName): string
    {
        foreach ($this->pathResolvers as $pathResolver) {
            try {
                return $pathResolver->getModuleAlias($resourceShortName);
            } catch (PathResolverException $e) {
                continue;
            }
        }

        throw new PathResolverException();
    }
}
