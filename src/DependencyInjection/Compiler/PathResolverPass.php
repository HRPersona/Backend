<?php

namespace Persona\Hris\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class PathResolverPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('persona.operation.path_resolver')) {
            return;
        }

        $services = $container->findTaggedServiceIds('persona.module');
        $queue = new \SplPriorityQueue();
        foreach ($services as $serviceId => $tags) {
            foreach ($tags as $attributes) {
                $priority = $attributes['priority'] ?? 0;
                $queue->insert(new Reference($serviceId), $priority);
            }
        }

        $container->getDefinition('persona.operation.path_resolver')->replaceArgument(0, iterator_to_array($queue, false));
    }
}
