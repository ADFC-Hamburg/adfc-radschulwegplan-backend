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

namespace Tests\AppBundle\Controller\DangerPointController;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

abstract class DangerPointBaseTest extends WebTestCase
{
    const API_PATH = '/api/v1/danger_point';

    /**
     * @var array|null usefull to get References to the objects
     */
    public $fixtures = null;

    public function setUp()
    {
        $fixturesArray = array(
            'AppBundle\DataFixtures\DangerPointFixtures',
        );
        $this->fixtures = $this->loadFixtures(
            $fixturesArray,
            null,
            'doctrine',
            ORMPurger::PURGE_MODE_TRUNCATE)->getReferenceRepository();
    }

    public function assertDangerPointCompare(string $dangerPointRef, $data)
    {
        $dp = $this->fixtures->getReference($dangerPointRef);
        self::assertSame($dp->getId(), $data['id'], 'Id not equal on dangerPoint ' + $dangerPointRef);
        self::assertSame($dp->getPos(), $data['pos'], 'Position not equal on dangerPoint ' + $dangerPointRef);
        self::assertSame($dp->getTitle(), $data['title'], 'Title not equal on dangerPoint ' + $dangerPointRef);
        self::assertSame($dp->getDescription(), $data['description'], 'Title not equal on dangerPoint ' + $dangerPointRef);
        self::assertSame($dp->getType()->getId(), $data['type']['id'], 'Type not equal on dangerPoint ' + $dangerPointRef);
        self::assertSame($dp->isDanger(), $data['danger'], 'Danger not equal on dangerPoint ' + $dangerPointRef);
        self::assertSame($dp->isArea(), $data['area'], 'Area not equal on dangerPoint ' + $dangerPointRef);
    }

    /**
     * @return Client
     */
    protected function createAuthorizedClient(string $userRef)
    {
        $this->loginAs($this->fixtures->getReference($userRef), 'main');

        return $this->makeClient();
    }
}
