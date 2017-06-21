<?php

namespace Persona\Hris\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class Configuration implements ConfigurationInterface
{
    const ALIAS = 'persona';

    /**
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $root = $treeBuilder->root(self::ALIAS);
        $root
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('cache_lifetime')
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->children()
                        ->integerNode('result_lifetime')->defaultValue(1)->end()
                        ->integerNode('response_lifetime')->defaultValue(1)->end()
                    ->end()
                ->end()
                ->scalarNode('default_password')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('upload_dir')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
