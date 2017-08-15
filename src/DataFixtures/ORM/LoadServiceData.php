<?php

namespace Persona\Hris\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Persona\Hris\Entity\Service;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Yaml\Yaml;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
class LoadServiceData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $path = sprintf('%s/data/%s', $this->container->getParameter('kernel.root_dir'), 'services.yml');
        $datas = Yaml::parse(file_get_contents($path));
        foreach ($datas as $data) {
            $service = new Service();
            $service->setName($data['name']);
            $this->setReference($data['ref'], $service);

            $manager->persist($service);
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
