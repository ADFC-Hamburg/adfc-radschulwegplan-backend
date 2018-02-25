<?php

namespace Tests\AppBundle\Controller;

class DangerPointTest extends BaseTestCase
{
    const GET_ALL_API_PATH="/api/v1/danger_point";
    const INSERT_API_PATH="/api/v1/danger_point/";
    const GET_ONE_API_PREFX="/api/v1/danger_point/";
    const DELETE_API_PREFX="/api/v1/danger_point/";
    
    public function testLogin() {
        $client=$this->createAdminAuthorizedClient();
        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Welcome to Symfony', $crawler->filter('#container h1')->text());
    }

    public function testGetAllNoAccessWithoutLogin() {
        $client = static::createClient();
        $crawler = $client->request('GET', self::GET_ALL_API_PATH);
        $this->assertEquals(302,$client->getResponse()->getStatusCode());
        $this->assertContains('/login',$client->getResponse()->getTargetUrl());
    }


    public function testGetAll() {
        $client = $this->createAdminAuthorizedClient();
        $crawler = $client->request('GET', self::GET_ALL_API_PATH);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(20,count($data));
        for ($i = 0; $i < 20; $i++) {
            $this->assertEquals('point '.$i, $data[$i]['title']);
            $this->assertEquals('point desc '.$i, $data[$i]['description']);
            $this->assertEquals($i, $data[$i]['type_id']);
        }
    }

    public function testInsert() {
        $client = $this->createAdminAuthorizedClient();
        $crawler = $client->request(
            'POST',
            self::INSERT_API_PATH,
            array(
                'lat' => 53.51142,
                'lon' => 10.101,
                'title' => 'Bordstein zu hoch',
                'description' => 'Der Bordstein ist hier 50 cm',
                'typeId' => 9
            )
        );
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('id', $data);
        $this->assertEquals(9, $data['type_id']);
        $this->assertEquals('SRID=4326;POINT(53.511420 10.101000)', $data['pos']);
        $this->assertEquals('Bordstein zu hoch', $data['title']);
        $this->assertEquals('Der Bordstein ist hier 50 cm', $data['description']);
        $this->assertEquals('test-admin', $data['created_by']['username']);
        $this->assertEquals('test-admin', $data['changed_by']['username']);

        $client = $this->createAdminAuthorizedClient();
        $olddata= $data;
        $crawler = $client->request(
            'GET',
            self::GET_ONE_API_PREFX.$olddata['id']);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($olddata['id'], $data['id']);
        $this->assertEquals(9, $data['type_id']);
        $this->assertEquals('SRID=4326;POINT(53.51142 10.101)', $data['pos']);
        $this->assertEquals('Bordstein zu hoch', $data['title']);
        $this->assertEquals('Der Bordstein ist hier 50 cm', $data['description']);
        $this->assertEquals('test-admin', $data['created_by']['username']);
        $this->assertEquals('test-admin', $data['changed_by']['username']);
        $crawler = $client->request(
            'DELETE',
            self::DELETE_API_PREFX.$olddata['id']);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request(
            'DELETE',
            self::DELETE_API_PREFX.$olddata['id']);
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $crawler = $client->request(
            'GET',
            self::GET_ONE_API_PREFX.$olddata['id']);
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        
        
    }


}
