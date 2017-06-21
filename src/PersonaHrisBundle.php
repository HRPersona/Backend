<?php

namespace Persona\Hris;

use Persona\Hris\DependencyInjection\Compiler\ClearDeserializeRequestTagPass;
use Persona\Hris\DependencyInjection\Compiler\DoctrineQueryExtensionPass;
use Persona\Hris\DependencyInjection\Compiler\ExcludeAuthorizationPass;
use Persona\Hris\DependencyInjection\Compiler\ExcludeLoggingPass;
use Persona\Hris\DependencyInjection\Compiler\PathResolverPass;
use Persona\Hris\DependencyInjection\PersonaHrisExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
class PersonaHrisBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new DoctrineQueryExtensionPass());
        $container->addCompilerPass(new ClearDeserializeRequestTagPass());
        $container->addCompilerPass(new PathResolverPass());
        $container->addCompilerPass(new ExcludeAuthorizationPass());
        $container->addCompilerPass(new ExcludeLoggingPass());
    }

    public function getContainerExtension()
    {
        return new PersonaHrisExtension();
    }
}
