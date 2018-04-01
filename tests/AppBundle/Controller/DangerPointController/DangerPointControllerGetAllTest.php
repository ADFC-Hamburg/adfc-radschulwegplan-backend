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

class DangerPointControllerGetAllTest extends DangerPointBaseTest
{
    public function testGetAllAsAdmin()
    {
        $client = $this->createAuthorizedClient('adfc-admin-user');
        $crawler = $client->request('GET', self::API_PATH);
        $this->assertStatusCode(200, $client);
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertSame(20, count($data));
        for ($i = 0; $i < 20; ++$i) {
            $this->assertSame('point '.$i, $data[$i]['title']);
            $this->assertSame('point desc '.$i, $data[$i]['description']);
            $this->assertSame($i, $data[$i]['type_id']);
            $data = json_decode($client->getResponse()->getContent(), true);
            $this->assertDangerPointCompare('danger-point' + $i, $data[$i]);
        }
    }

    public function testGetOneAsAdmin()
    {
        $client = $this->createAuthorizedClient('adfc-admin-user');
        for ($i = 0; $i < 20; ++$i) {
            $id = $this->fixtures->getReference('danger-point' + $i)->getId();
            $crawler = $client->request('GET', self::API_PATH.'/'.$id);
            $this->assertStatusCode(200, $client);
            $data = json_decode($client->getResponse()->getContent(), true);
            $this->assertDangerPointCompare('danger-point' + $i, $data);
        }
    }

    public function testGetOneAsStudent1()
    {
        $client = $this->createAuthorizedClient('student1-user');
        for ($i = 0; $i < 10; ++$i) {
            $id = $this->fixtures->getReference('danger-point' + $i)->getId();
            $crawler = $client->request('GET', self::API_PATH.'/'.$id);
            $this->assertStatusCode(200, $client);
            $data = json_decode($client->getResponse()->getContent(), true);
            $this->assertDangerPointCompare('danger-point' + $i, $data);
        }
        for ($i = 10; $i < 20; ++$i) {
            $id = $this->fixtures->getReference('danger-point' + $i)->getId();
            $crawler = $client->request('GET', self::API_PATH.'/'.$id);
            $this->assertStatusCode(403, $client);
        }
    }

    public function testGetAllAsStudent1()
    {
        $client = $this->createAuthorizedClient('student1-user');
        $crawler = $client->request('GET', self::API_PATH);
        $this->assertStatusCode(200, $client);
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertSame(10, count($data));
        for ($i = 0; $i < 10; ++$i) {
            $this->assertSame('point '.$i, $data[$i]['title']);
            $this->assertSame('point desc '.$i, $data[$i]['description']);
            $this->assertSame($i, $data[$i]['type_id']);
            $data = json_decode($client->getResponse()->getContent(), true);
            $this->assertDangerPointCompare('danger-point' + $i, $data[$i]);
        }
    }
}
