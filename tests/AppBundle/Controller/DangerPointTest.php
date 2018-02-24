<?php

namespace Tests\AppBundle\Controller;


class DangerPointTest extends BaseTestCase
{
    const GET_ALL_API_PATH="/api/v1/danger_point";
    
    public function testLogin() {
        $client=$this->createAdminAuthorizedClient();
        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Welcome to Symfony', $crawler->filter('#container h1')->text());
    }

    public function testGetNoAccessWithoutLogin() {
        $client = static::createClient();
        $crawler = $client->request('GET', self::GET_ALL_API_PATH);
        $this->assertEquals(302,$client->getResponse()->getStatusCode());
        $this->assertContains('/login',$client->getResponse()->getTargetUrl());
    }

    public function testGetWithLogin() {
        $client = $this->createAdminAuthorizedClient();
        $crawler = $client->request('GET', self::GET_ALL_API_PATH);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
        
    
}
