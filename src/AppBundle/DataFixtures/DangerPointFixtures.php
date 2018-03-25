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

use AppBundle\Entity\DangerPoint;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class DangerPointFixtures extends Fixture implements ORMFixtureInterface, DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // create 20 DangerPoints
        for ($i = 0; $i < 20; ++$i) {
            $pt = new DangerPoint();
            $pt->setTitle('point '.$i);
            $pt->setDescription('point desc '.$i);
            $pt->setTypeId($i);
            $lat = 53.5 + (mt_rand(0, 1000) / 100);
            $lon = 10 + (mt_rand(0, 100) / 100);
            $pt->setPos(sprintf('SRID=4326;POINT(%f %f)', $lat, $lon));
            $user = $this->getReference('student-user');
            $pt->setCreatedNow($user);
            $manager->persist($pt);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}
