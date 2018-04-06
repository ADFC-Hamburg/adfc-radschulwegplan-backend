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

    public function testStudentNotAllowedToCreateASchool()
    {
        $client = $this->createStudent1AuthorizedClient();
        // create item
        $client->request(
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
        if (403 != $client->getResponse()->getStatusCode()) {
            print_r($client->getResponse());
        }
        $this->assertSame(403, $client->getResponse()->getStatusCode());
    }

    public function testOldCountSchools()
    {
        $client = $this->createAdminAuthorizedClient();

        // old list
        $client->request(
            'GET',
            self::API_PATH,
            array()
        );
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);

        return count($data);
    }

    public function testCreateSchool()
    {
        $client = $this->createAdminAuthorizedClient();
        // create item
        $client->request(
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
        if (200 != $client->getResponse()->getStatusCode()) {
            print_r($client->getResonse());
        }
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('id', $data);

        return $data['id'];
    }

    /**
     * @depends testCreateSchool
     */
    public function testGetSchool($id)
    {
        $client = $this->createAdminAuthorizedClient();

        $client->request(
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
    }

    /**
     * @depends testCreateSchool
     * @depends testGetSchool
     */
    public function testModifySchoolFailByStudent($id)
    {
        $client = $this->createStudent1AuthorizedClient();

        $client->request(
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
    }

    /**
     * @depends testCreateSchool
     * @depends testModifySchoolFailByStudent
     */
    public function testModifySchoolOkay($id)
    {
        $client = $this->createAdminAuthorizedClient();

        $client->request(
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
    }

    /**
     * @depends testCreateSchool
     * @depends testModifySchoolOkay
     */
    public function testModifySchoolValues($id)
    {
        $client = $this->createAdminAuthorizedClient();

        $client->request(
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
    }

    /**
     * @depends testCreateSchool
     * @depends testOldCountSchools
     * @depends testModifySchoolOkay
     */
    public function testListCountIsOneMore($id, $oldCount)
    {
        // FIXME why do I need to load the client again, otherwise route below will fail
        $client = $this->createAdminAuthorizedClient();
        $client->request(
            'GET',
            self::API_PATH,
            array()
        );
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);
        $newCount = count($data);

        $this->assertSame($oldCount + 1, $newCount);
    }

    /**
     * @depends testCreateSchool
     * @depends testListCountIsOneMore
     */
    public function testStudentNotAllowedToDelete($id)
    {
        $client = $this->createStudent1AuthorizedClient();
        $client->request(
            'DELETE',
            self::API_PATH.'/'.$id
        );
        $this->assertSame(403, $client->getResponse()->getStatusCode());
    }

    /**
     * @depends testCreateSchool
     * @depends testListCountIsOneMore
     * @depends testModifySchoolValues
     * @depends testStudentNotAllowedToDelete
     */
    public function testDeleteOkay($id)
    {
        $client = $this->createAdminAuthorizedClient();
        $client->request(
            'DELETE',
            self::API_PATH.'/'.$id
        );
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        return $id;
    }

    /**
     * @depends testDeleteOkay
     */
    public function testDeleteItemNotThere($id)
    {
        // Delete again -> 404
        $client = $this->createAdminAuthorizedClient();
        $client->request(
            'DELETE',
            self::API_PATH.'/'.$id
        );
        $this->assertSame(404, $client->getResponse()->getStatusCode());
    }
}
