<?php

namespace Persona\Hris\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Persona\Hris\Core\Security\Model\ModuleInterface;
use Persona\Hris\Core\Security\Model\UserInterface;
use Persona\Hris\Entity\Role;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Yaml\Yaml;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@personahris.com>
 */
final class LoadRoleData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $userPath = sprintf('%s/data/%s', $this->container->getParameter('kernel.root_dir'), 'users.yml');
        $users = Yaml::parse(file_get_contents($userPath));
        foreach ($users as $user) {
            $modulePath = sprintf('%s/data/%s', $this->container->getParameter('kernel.root_dir'), 'modules.yml');
            $modules = Yaml::parse(file_get_contents($modulePath));
            foreach ($modules as $module) {
                $role = new Role();
                /** @var UserInterface $userObj */
                $userObj = $this->getReference($user['ref']);
                /** @var ModuleInterface $moduleObj */
                $moduleObj = $this->getReference($module['ref']);

                $role->setUser($userObj);
                $role->setModule($moduleObj);
                $role->setAddable(true);
                $role->setEditable(true);
                $role->setDeletable(true);
                $role->setViewable(true);

                $manager->persist($role);
            }
        }

        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 4;
    }
}
