<?php

namespace Persona\Hris\Core\Operation;

use ApiPlatform\Core\PathResolver\OperationPathResolverInterface;
use Doctrine\Common\Util\Inflector;
use Persona\Hris\Core\Util\StringUtil;

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
        $resourceShortName = StringUtil::dash($resourceShortName);
        $moduleShortName = explode('-', $resourceShortName)[0];

        if ($moduleShortName !== $resourceShortName) {
            try {
                $module = strtolower($this->pathResolver->getModuleAlias($moduleShortName));
                $table = str_replace($moduleShortName.'-', '', $resourceShortName);

                $resourceShortName = sprintf('%s/%s', $module, $table);
            } catch (PathResolverException $e) {
                //nothing to do
            }
        }

        $path = Inflector::pluralize($resourceShortName);
        if (!$collection) {
            $path .= '/{id}';
        }

        $path .= '.{_format}';

        return $path;
    }
}
