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

use AppBundle\Entity\School;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class SchoolFixtures extends Fixture implements ORMFixtureInterface, DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $s = new School();
        $s->setName('Goethe-Schule-Harburg');
        $s->setStreet('Eißendorfer Straße 26');
        $s->setPostalCode('21073');
        $s->setPlace('Hamburg');
        $s->setWebpage('https://goethe-schule-harburg.schulhomepages.hamburg.de/');
        $user = $this->getReference('adfc-admin-user');
        $s->setCreatedNow($user);
        $manager->persist($s);
        $manager->flush();

        $this->addReference('gsh-school', $s);

        $s = new School();
        $s->setName('Schule-Hausbruch');
        $s->setStreet('Hausbrucher Bahnhofstr.19');
        $s->setPostalCode('21147');
        $s->setPlace('Hamburg');
        $user = $this->getReference('adfc-admin-user');
        $s->setCreatedNow($user);
        $manager->persist($s);
        $manager->flush();

        $this->addReference('hausbruch-school', $s);
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}
