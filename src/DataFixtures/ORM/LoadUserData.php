<?php

namespace Persona\Hris\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Persona\Hris\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Yaml\Yaml;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $path = sprintf('%s/Resources/data/%s', $this->container->getParameter('kernel.root_dir'), 'users.yml');
        $datas = Yaml::parse(file_get_contents($path));
        foreach ($datas as $data) {
            $user = new User();
            $user->setUsername($data['username']);
            $user->setFullName($data['fullname']);
            $user->setEmail($data['email']);
            $user->setPlainPassword($this->container->getParameter('persona.default_password'));
            $user->setEnabled(true);
            $this->setReference($data['ref'], $user);

            $manager->persist($user);
        }

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}
