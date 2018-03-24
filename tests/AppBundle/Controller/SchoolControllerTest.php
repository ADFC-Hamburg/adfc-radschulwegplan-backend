<?php

namespace Tests\AppBundle\Controller;



class SchoolControllerTest extends BaseTestCase
{
    const API_PATH = "api/v1/school";
    
    public function testNewSchool()
    {
        
        $client = $this->createAdminAuthorizedClient();

        // old list
        $crawler = $client->request(
            'GET',
            self::API_PATH,
            array()
        );
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);
        $oldCount=count($data);

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
                'webpage' => 'https://www.ebert-gymnasium.de/'
            )
        );
        $this->assertEquals(403, $client->getResponse()->getStatusCode());

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
                'webpage' => 'https://www.ebert-gymnasium.de/'
            )
        );
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
$data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('id', $data);
        $id=$data['id'];

                // FIXME why do I need to load the client again, otherwise route below will fail
        $client = $this->createAdminAuthorizedClient();

        $crawler = $client->request(
            'GET',
            self::API_PATH."/".$id
        );
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($data['id'], $id);
        $this->assertEquals("Ebert Gymnasium",$data['name']);
        $this->assertEquals("Alter Postweg 32", $data['street']);
        $this->assertEquals("21073", $data['postalcode']);
        $this->assertEquals("Hamburg-Harburg", $data['place']);
        $this->assertEquals("https://www.ebert-gymnasium.de/", $data['webpage']);

        $client = $this->createStudentAuthorizedClient();

        $crawler = $client->request(
            'PUT',
            self::API_PATH."/".$id,
            array(
                'name' => 'Friedrich Ebert Gymnasium',
                'street' => 'Alter Postweg 36',
                'postalcode' => '21075',
                'place' => 'Hamburg',
                'webpage' => 'http://www.ebert-gymnasium.de/'
            )
        );

        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        $client = $this->createAdminAuthorizedClient();

        $crawler = $client->request(
            'PUT',
            self::API_PATH."/".$id,
            array(
                'name' => 'Friedrich Ebert Gymnasium',
                'street' => 'Alter Postweg 36',
                'postalcode' => '21075',
                'place' => 'Hamburg',
                'webpage' => 'http://www.ebert-gymnasium.de/'
            )
        );
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        // FIXME why do I need to load the client again, otherwise route below will fail
        $client = $this->createAdminAuthorizedClient();

        $crawler = $client->request(
            'GET',
            self::API_PATH."/".$id
        );
      $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($data['id'], $id);
        $this->assertEquals("Friedrich Ebert Gymnasium",$data['name']);
        $this->assertEquals("Alter Postweg 36", $data['street']);
        $this->assertEquals("21075", $data['postalcode']);
        $this->assertEquals("Hamburg", $data['place']);
        $this->assertEquals("http://www.ebert-gymnasium.de/", $data['webpage']);
        
        // FIXME why do I need to load the client again, otherwise route below will fail
        $client = $this->createAdminAuthorizedClient();
        $crawler = $client->request(
            'GET',
            self::API_PATH,
            array()
        );
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);
        $newCount=count($data);

        $this->assertEquals($oldCount+1, $newCount);

        $client = $this->createStudentAuthorizedClient();
        $crawler = $client->request(
            'DELETE',
            self::API_PATH."/".$id
        );
        $this->assertEquals(403, $client->getResponse()->getStatusCode());
        
        $client = $this->createAdminAuthorizedClient();
        $crawler = $client->request(
            'DELETE',
            self::API_PATH."/".$id
        );
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // Delete again -> 404
        // FIXME why do I need to load the client again, otherwise route below will fail
        $client = $this->createAdminAuthorizedClient();
        $crawler = $client->request(
            'DELETE',
            self::API_PATH."/".$id
        );
        $this->assertEquals(404, $client->getResponse()->getStatusCode());

        
    }

}
