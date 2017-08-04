<?php

namespace Persona\Hris\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Finder\Finder;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class PersonaHrisExtension extends Extension
{
    /**
     * @param array            $configs   An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $reflection = new \ReflectionObject($this);
        $directory = sprintf('%s/../Resources/config', dirname($reflection->getFileName()));

        $loader = new YamlFileLoader($container, new FileLocator($directory));

        $finder = new Finder();
        $finder->in($directory);
        $finder->ignoreDotFiles(true);
        $files = $finder->files()->name('*.yml');

        foreach ($files as $file) {
            /* @var \SplFileInfo $file */
            $loader->load($file->getFilename());
        }

        $processor = new Processor();
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, $configs);

        $container->setParameter(sprintf('%s.default_password', Configuration::ALIAS), $config['default_password']);
        $container->setParameter(sprintf('%s.upload_dir', Configuration::ALIAS), $config['upload_dir']);
    }

    public function getAlias()
    {
        return Configuration::ALIAS;
    }
}
