<?php

namespace Persona\Hris\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Persona\Hris\Entity\Client;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Yaml\Yaml;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class LoadClientData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $path = sprintf('%s/data/%s', $this->container->getParameter('kernel.root_dir'), 'clients.yml');
        $datas = Yaml::parse(file_get_contents($path));
        foreach ($datas as $data) {
            $client = new Client();
            $client->setName($data['name']);
            $client->setUserId($this->getReference($data['user']));
            $this->setReference($data['ref'], $client);

            $manager->persist($client);
        }

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 2;
    }
}
