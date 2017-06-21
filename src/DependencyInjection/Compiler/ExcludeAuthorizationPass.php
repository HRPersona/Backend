<?php

namespace Persona\Hris\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class ExcludeAuthorizationPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('persona.security.authorization.authorization_factory')) {
            return;
        }

        $services = $container->findTaggedServiceIds('persona.exclude_path');
        $excludePaths = [];
        foreach ($services as $serviceId => $tags) {
            $excludePaths[] = new Reference($serviceId);
        }

        $container->getDefinition('persona.security.authorization.authorization_factory')->replaceArgument(0, $excludePaths);
    }
}
