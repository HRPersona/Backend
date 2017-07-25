<?php

namespace Persona\Hris\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Persona\Hris\Entity\Module;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Yaml\Yaml;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class LoadModuleData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $path = sprintf('%s/data/%s', $this->container->getParameter('kernel.root_dir'), 'modules.yml');
        $datas = Yaml::parse(file_get_contents($path));
        foreach ($datas as $data) {
            $module = new Module();
            $module->setName($data['name']);
            $module->setGroupName($data['group']);
            $module->setDescription($data['description']);
            $module->setPath($data['path']);
            $module->setMenuOrder($data['menuOrder']);
            $module->setMenuDisplay($data['display']);
            $this->setReference($data['ref'], $module);

            $manager->persist($module);
        }

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 3;
    }
}
