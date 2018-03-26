<?php

/*
 * This file is part of the ADFC Radschulwegplan Backend package.
 *
 * <https://github.com/ADFC-Hamburg/adfc-radschulwegplan-backend>
 *
 * (c) 2018 by James Twellmeyer <jet02@twellmeyer.eu>
 * (c) 2018 by Sven Anders <github2018@sven.anders.hamburg>
 *
 * Released under the GPL 3.0
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Please also visit our (german) webpage about the project:
 *
 * <https://hamburg.adfc.de/verkehr/themen-a-z/kinder/schulwegplanung/>
 *
 */

namespace AppBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SchoolUserFixtures extends Fixture implements ORMFixtureInterface, ContainerAwareInterface, DependentFixtureInterface
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

        $school = $this->getReference('gsh-school');

        $user = $userManager->createUser();
        $user->setUsername('test-school1-admin');
        $user->setEmail('test-admin-school@example.com');
        $user->setPlainPassword('pass-admin-school1');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_SCHOOL_ADMIN'));
        $user->setSchool($school);
        $userManager->updateUser($user, true);

        $this->addReference('school1-admin-user', $user);

        $user = $userManager->createUser();
        $user->setUsername('test-school1-review');
        $user->setEmail('test-review@example.com');
        $user->setPlainPassword('pass-school-review');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_SCHOOL_REVIEW'));
        $user->setSchool($school);
        $userManager->updateUser($user, true);

        $this->addReference('review1-user', $user);

        $user = $userManager->createUser();
        $user->setUsername('test-1student');
        $user->setEmail('test-student@example.com');
        $user->setPlainPassword('pass-student');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_STUDENT'));
        $user->setSchool($school);
        $userManager->updateUser($user, true);

        $this->addReference('student1-user', $user);

        $school = $this->getReference('hausbruch-school');
        $user = $userManager->createUser();
        $user->setUsername('test-school2-admin');
        $user->setEmail('test-admin2-school@example.com');
        $user->setPlainPassword('pass-admin-school2');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_SCHOOL_ADMIN'));
        $user->setSchool($school);
        $userManager->updateUser($user, true);

        $this->addReference('school2-admin-user', $user);

        $user = $userManager->createUser();
        $user->setUsername('test-school2-review');
        $user->setEmail('test-review2@example.com');
        $user->setPlainPassword('pass-school-review');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_SCHOOL_REVIEW'));
        $user->setSchool($school);
        $userManager->updateUser($user, true);

        $this->addReference('review2-user', $user);

        $user = $userManager->createUser();
        $user->setUsername('test-2student');
        $user->setEmail('test-student2@example.com');
        $user->setPlainPassword('pass-student');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_STUDENT'));
        $user->setSchool($school);
        $userManager->updateUser($user, true);

        $this->addReference('student2-user', $user);
    }

    public function getDependencies()
    {
        return array(
            SchoolFixtures::class,
        );
    }
}
