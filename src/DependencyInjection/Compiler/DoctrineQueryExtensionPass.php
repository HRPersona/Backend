<?php

namespace Persona\Hris\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class DoctrineQueryExtensionPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('api_platform.doctrine.metadata_factory')) {
            return;
        }

        $collectionDataProviderDefinition = $container->getDefinition('persona.data_provider.collection_provider');
        $itemDataProviderDefinition = $container->getDefinition('persona.data_provider.item_provider');

        $collectionDataProviderDefinition->replaceArgument(1, $this->findSortedServices($container, 'api_platform.doctrine.orm.query_extension.collection'));
        $itemDataProviderDefinition->replaceArgument(3, $this->findSortedServices($container, 'api_platform.doctrine.orm.query_extension.item'));
    }

    /**
     * @param ContainerBuilder $container
     * @param string           $tag
     *
     * @return Reference[]
     */
    private function findSortedServices(ContainerBuilder $container, $tag)
    {
        $extensions = [];
        foreach ($container->findTaggedServiceIds($tag) as $serviceId => $tags) {
            foreach ($tags as $tag) {
                $priority = $tag['priority'] ?? 0;
                $extensions[$priority][] = new Reference($serviceId);
            }
        }
        krsort($extensions);

        // Flatten the array
        return empty($extensions) ? [] : call_user_func_array('array_merge', $extensions);
    }
}
