<?php

namespace Persona\Hris\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class FormulaPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('persona.insurance.formula_factory')) {
            return;
        }

        $definition = $container->findDefinition('persona.insurance.formula_factory');

        $taggedServices = $container->findTaggedServiceIds('persona.insurance_formula');
        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addFormula', array($id, new Reference($id)));
        }
    }
}
