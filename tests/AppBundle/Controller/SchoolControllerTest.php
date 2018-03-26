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

class SchoolControllerTest extends BaseTestCase
{
    const API_PATH = 'api/v1/school';

    public function testNewSchool()
    {
        $client = $this->createAdminAuthorizedClient();

        // old list
        $crawler = $client->request(
            'GET',
            self::API_PATH,
            array()
        );
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);
        $oldCount = count($data);

        $client = $this->createStudentAuthorizedClient();
        // create item
        $crawler = $client->request(
            'POST',
            self::API_PATH,
            array(
                'name' => 'Ebert Gymnasium',
                'street' => 'Alter Postweg 32',
                'postalcode' => '21073',
                'place' => 'Hamburg-Harburg',
                'webpage' => 'https://www.ebert-gymnasium.de/',
            )
        );
        $this->assertSame(403, $client->getResponse()->getStatusCode());

        $client = $this->createAdminAuthorizedClient();
        // create item
        $crawler = $client->request(
            'POST',
            self::API_PATH,
            array(
                'name' => 'Ebert Gymnasium',
                'street' => 'Alter Postweg 32',
                'postalcode' => '21073',
                'place' => 'Hamburg-Harburg',
                'webpage' => 'https://www.ebert-gymnasium.de/',
            )
        );
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('id', $data);
        $id = $data['id'];

        // FIXME why do I need to load the client again, otherwise route below will fail
        $client = $this->createAdminAuthorizedClient();

        $crawler = $client->request(
            'GET',
            self::API_PATH.'/'.$id
        );
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertSame($data['id'], $id);
        $this->assertSame('Ebert Gymnasium', $data['name']);
        $this->assertSame('Alter Postweg 32', $data['street']);
        $this->assertSame('21073', $data['postalcode']);
        $this->assertSame('Hamburg-Harburg', $data['place']);
        $this->assertSame('https://www.ebert-gymnasium.de/', $data['webpage']);

        $client = $this->createStudentAuthorizedClient();

        $crawler = $client->request(
            'PUT',
            self::API_PATH.'/'.$id,
            array(
                'name' => 'Friedrich Ebert Gymnasium',
                'street' => 'Alter Postweg 36',
                'postalcode' => '21075',
                'place' => 'Hamburg',
                'webpage' => 'http://www.ebert-gymnasium.de/',
            )
        );

        $this->assertSame(403, $client->getResponse()->getStatusCode());
        $client = $this->createAdminAuthorizedClient();

        $crawler = $client->request(
            'PUT',
            self::API_PATH.'/'.$id,
            array(
                'name' => 'Friedrich Ebert Gymnasium',
                'street' => 'Alter Postweg 36',
                'postalcode' => '21075',
                'place' => 'Hamburg',
                'webpage' => 'http://www.ebert-gymnasium.de/',
            )
        );
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        // FIXME why do I need to load the client again, otherwise route below will fail
        $client = $this->createAdminAuthorizedClient();

        $crawler = $client->request(
            'GET',
            self::API_PATH.'/'.$id
        );
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertSame($data['id'], $id);
        $this->assertSame('Friedrich Ebert Gymnasium', $data['name']);
        $this->assertSame('Alter Postweg 36', $data['street']);
        $this->assertSame('21075', $data['postalcode']);
        $this->assertSame('Hamburg', $data['place']);
        $this->assertSame('http://www.ebert-gymnasium.de/', $data['webpage']);

        // FIXME why do I need to load the client again, otherwise route below will fail
        $client = $this->createAdminAuthorizedClient();
        $crawler = $client->request(
            'GET',
            self::API_PATH,
            array()
        );
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);
        $newCount = count($data);

        $this->assertSame($oldCount + 1, $newCount);

        $client = $this->createStudentAuthorizedClient();
        $crawler = $client->request(
            'DELETE',
            self::API_PATH.'/'.$id
        );
        $this->assertSame(403, $client->getResponse()->getStatusCode());

        $client = $this->createAdminAuthorizedClient();
        $crawler = $client->request(
            'DELETE',
            self::API_PATH.'/'.$id
        );
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        // Delete again -> 404
        // FIXME why do I need to load the client again, otherwise route below will fail
        $client = $this->createAdminAuthorizedClient();
        $crawler = $client->request(
            'DELETE',
            self::API_PATH.'/'.$id
        );
        $this->assertSame(404, $client->getResponse()->getStatusCode());
    }
}
