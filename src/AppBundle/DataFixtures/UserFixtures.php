<?php
namespace AppBundle\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;

use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserFixtures extends Fixture implements ORMFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    public function load(ObjectManager $manager)
    {  // Get our userManager, you must implement `ContainerAwareInterface`
        $userManager = $this->container->get('fos_user.user_manager');

        // Create our user and set details
        $user = $userManager->createUser();
        $user->setUsername('test-admin');
        $user->setEmail('test-admin@example.com');
        $user->setPlainPassword('pass-admin');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_ADMIN'));
        $userManager->updateUser($user, true);

        $this->addReference('adfc-admin-user', $user);

    }
}
