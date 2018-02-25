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

        $user = $userManager->createUser();
        $user->setUsername('test-school-admin');
        $user->setEmail('test-admin-school@example.com');
        $user->setPlainPassword('pass-admin-school');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_SCHOOL_ADMIN'));
        $userManager->updateUser($user, true);

        $this->addReference('school-admin-user', $user);

        $user = $userManager->createUser();
        $user->setUsername('test-school-review');
        $user->setEmail('test-review@example.com');
        $user->setPlainPassword('pass-school-review');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_SCHOOL_REVIEW'));
        $userManager->updateUser($user, true);

        $this->addReference('review-user', $user);
        
        $user = $userManager->createUser();
        $user->setUsername('test-student');
        $user->setEmail('test-student@example.com');
        $user->setPlainPassword('pass-student');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_STUDENT'));
        $userManager->updateUser($user, true);
        
        $this->addReference('student-user', $user);
    }
}
