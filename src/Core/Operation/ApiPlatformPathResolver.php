<?php

namespace Persona\Hris\Core\Operation;

use ApiPlatform\Core\PathResolver\OperationPathResolverInterface;
use Doctrine\Common\Util\Inflector;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class ApiPlatformPathResolver implements OperationPathResolverInterface
{
    /**
     * @var PathResolverInterface
     */
    private $pathResolver;

    /**
     * @param PathResolverInterface $pathResolver
     */
    public function __construct(PathResolverInterface $pathResolver)
    {
        $this->pathResolver = $pathResolver;
    }

    /**
     * @param string $resourceShortName
     * @param array  $operation
     * @param bool   $collection
     *
     * @return string
     */
    public function resolveOperationPath(string $resourceShortName, array $operation, bool $collection): string
    {
        try {
            $resourceShortName = strtolower($this->pathResolver->getModuleAlias($resourceShortName));
        } catch (PathResolverException $e) {
            //nothing to do
        }

        $path = Inflector::pluralize($resourceShortName);
        if (!$collection) {
            $path .= '/{id}';
        }

        $path .= '.{_format}';

        return $path;
    }
}
