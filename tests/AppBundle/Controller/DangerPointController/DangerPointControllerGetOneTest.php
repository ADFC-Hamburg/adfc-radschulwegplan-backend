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

class DangerPointControllerGetOneTest extends DangerPointBaseTest
{
    public function testGetOneAsAdmin()
    {
        $client = $this->createAuthorizedClient('adfc-admin-user');
        for ($i = 0; $i < 20; ++$i) {
            $id = $this->getFixtureFromRef('danger-point' + $i)->getId();
            $client->request('GET', self::API_PATH.'/'.$id);
            $this->assertStatusCode(200, $client);
            $data = json_decode($client->getResponse()->getContent(), true);
            $this->assertDangerPointCompare('danger-point' + $i, $data);
        }
    }

    public function testGetOneAsStudent1()
    {
        $client = $this->createAuthorizedClient('student1-user');
        for ($i = 0; $i < 10; ++$i) {
            $id = $this->getFixtureFromRef('danger-point' + $i)->getId();
            $client->request('GET', self::API_PATH.'/'.$id);
            $this->assertStatusCode(200, $client);
            $data = json_decode($client->getResponse()->getContent(), true);
            $this->assertDangerPointCompare('danger-point' + $i, $data);
        }
        for ($i = 10; $i < 20; ++$i) {
            $id = $this->getFixtureFromRef('danger-point' + $i)->getId();
            $client->request('GET', self::API_PATH.'/'.$id);
            $this->assertStatusCode(403, $client);
        }
    }
}
