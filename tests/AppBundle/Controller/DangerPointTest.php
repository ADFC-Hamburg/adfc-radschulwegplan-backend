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

namespace Tests\AppBundle\Controller;

class DangerPointTest extends BaseTestCase
{
    const GET_ALL_API_PATH = '/api/v1/danger_point';
    const INSERT_API_PATH = '/api/v1/danger_point';
    const GET_ONE_API_PREFIX = '/api/v1/danger_point/';
    const DELETE_API_PREFIX = '/api/v1/danger_point/';
    const UPDATE_API_PREFIX = '/api/v1/danger_point/';

    public function testLogin()
    {
        $client = $this->createAdminAuthorizedClient();
        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Welcome to Symfony', $crawler->filter('#container h1')->text());
    }

    public function testGetAllNoAccessWithoutLogin()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', self::GET_ALL_API_PATH);
        $this->assertSame(302, $client->getResponse()->getStatusCode());
        $this->assertContains('/login', $client->getResponse()->getTargetUrl());
    }

    public function testGetAll()
    {
        $client = $this->createAdminAuthorizedClient();
        $crawler = $client->request('GET', self::GET_ALL_API_PATH);
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertSame(20, count($data));
        for ($i = 0; $i < 20; ++$i) {
            $this->assertSame('point '.$i, $data[$i]['title']);
            $this->assertSame('point desc '.$i, $data[$i]['description']);
            $this->assertSame($i, $data[$i]['type_id']);
        }
    }

    public function testInsert()
    {
        $client = $this->createAdminAuthorizedClient();
        // test typeId is required:
        $crawler = $client->request(
            'POST',
            self::INSERT_API_PATH,
            array(
                'lat' => 53.51142,
                'lon' => 10.101,
            )
        );
        $this->assertSame(406, $client->getResponse()->getStatusCode());

        // test lon is required:
        $crawler = $client->request(
            'POST',
            self::INSERT_API_PATH,
            array(
                'lat' => 53.51142,
                'typeId' => 9,
            )
        );
        $this->assertSame(406, $client->getResponse()->getStatusCode());

        // test lat is required:
        $crawler = $client->request(
            'POST',
            self::INSERT_API_PATH,
            array(
                'lon' => 10.101,
                'typeId' => 9,
            )
        );
        $this->assertSame(406, $client->getResponse()->getStatusCode());

        // create item
        $crawler = $client->request(
            'POST',
            self::INSERT_API_PATH,
            array(
                'lat' => 53.51142,
                'lon' => 10.101,
                'title' => 'Bordstein zu hoch',
                'description' => 'Der Bordstein ist hier 50 cm',
                'typeId' => 9,
            )
        );
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('id', $data);
        $id = $data['id'];
        $this->assertSame(9, $data['type_id']);
        $this->assertSame('SRID=4326;POINT(53.511420 10.101000)', $data['pos']);
        $this->assertSame('Bordstein zu hoch', $data['title']);
        $this->assertSame('Der Bordstein ist hier 50 cm', $data['description']);
        $this->assertSame('test-admin', $data['created_by']['username']);
        $this->assertSame('test-admin', $data['changed_by']['username']);

        // get item back
        $client = $this->createAdminAuthorizedClient();
        $olddata = $data;
        $crawler = $client->request(
            'GET',
            self::GET_ONE_API_PREFIX.$id
        );
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertSame($olddata['id'], $data['id']);
        $this->assertSame(9, $data['type_id']);
        $this->assertSame('SRID=4326;POINT(53.51142 10.101)', $data['pos']);
        $this->assertSame('Bordstein zu hoch', $data['title']);
        $this->assertSame('Der Bordstein ist hier 50 cm', $data['description']);
        $this->assertSame('test-admin', $data['created_by']['username']);
        $this->assertSame('test-admin', $data['changed_by']['username']);

        // change item
        $crawler = $client->request(
            'PUT',
            self::UPDATE_API_PREFIX.$id,
            array(
                'lat' => 53.542,
                'lon' => 10.142,
                'title' => 'Bordstein zu tief',
                'description' => 'Der Bordstein ist hier -50 cm',
                'typeId' => 19,
            )
        );
        if (200 != $client->getResponse()->getStatusCode()) {
            print_r($client->getInternalRequest());
            print_r($client->getResponse());
        }
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        // get changed item back
        $crawler = $client->request(
            'GET',
            self::GET_ONE_API_PREFIX.$id
        );
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertSame($olddata['id'], $data['id']);
        $this->assertSame(19, $data['type_id']);
        $this->assertSame('SRID=4326;POINT(53.542 10.142)', $data['pos']);
        $this->assertSame('Bordstein zu tief', $data['title']);
        $this->assertSame('Der Bordstein ist hier -50 cm', $data['description']);
        $this->assertSame('test-admin', $data['created_by']['username']);
        $this->assertSame($olddata['created'], $data['created']);
        $this->assertSame('test-admin', $data['changed_by']['username']);

        // delete
        $crawler = $client->request(
            'DELETE',
            self::DELETE_API_PREFIX.$id
        );
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        // delete again, should fail
        $crawler = $client->request(
            'DELETE',
            self::DELETE_API_PREFIX.$id
        );
        $this->assertSame(404, $client->getResponse()->getStatusCode());

        // get deleted item, should fail
        $crawler = $client->request(
            'GET',
            self::GET_ONE_API_PREFIX.$id
        );
        $this->assertSame(404, $client->getResponse()->getStatusCode());
    }
}
