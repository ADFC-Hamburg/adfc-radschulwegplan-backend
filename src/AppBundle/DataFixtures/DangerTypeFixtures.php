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
use Doctrine\Common\Persistence\ObjectManager;

class DangerTypeFixtures extends Fixture implements ORMFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $repo = $manager->getRepository('AppBundle:DangerType');
        $arr = $repo->insertDangerTypes();
        $i = 0;
        foreach ($arr as $t) {
            $typeName = 'DangerType-'.$i;
            $this->addReference($typeName, $t);
            ++$i;
        }
    }
}
