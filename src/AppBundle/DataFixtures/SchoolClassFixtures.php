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

use AppBundle\Entity\SchoolClass;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class SchoolClassFixtures extends Fixture implements ORMFixtureInterface, DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = $this->getReference('adfc-admin-user');
        $gsh = $this->getReference('gsh-school');
        $clNames = array('5a', '5b', '6a', '6b');
        foreach ($clNames as $clName) {
            $sc = new SchoolClass();
            $sc->setName($clName);
            $sc->setSchool($gsh);
            $sc->setCreatedNow($user);
            $manager->persist($sc);
            $manager->flush();
            $this->addReference('class-gsh-'.$clName, $sc);
        }

        $hausbruch = $this->getReference('hausbruch-school');

        $clNames = array('1', '2', '3', '4', '5a', '6a', '6b');
        foreach ($clNames as $clName) {
            $sc = new SchoolClass();
            $sc->setName($clName);
            $sc->setSchool($hausbruch);
            $sc->setCreatedNow($user);
            $manager->persist($sc);
            $manager->flush();
            $this->addReference('class-hb-'.$clName, $sc);
        }
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            SchoolFixtures::class,
        );
    }
}
