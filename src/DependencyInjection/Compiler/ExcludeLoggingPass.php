<?php

namespace Persona\Hris\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class ExcludeLoggingPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('persona.logger.exclude_logger_factory')) {
            return;
        }

        $services = $container->findTaggedServiceIds('persona.exclude_log');
        $excludePaths = [];
        foreach ($services as $serviceId => $tags) {
            $excludePaths[] = new Reference($serviceId);
        }

        $container->getDefinition('persona.logger.exclude_logger_factory')->replaceArgument(0, $excludePaths);
    }
}
