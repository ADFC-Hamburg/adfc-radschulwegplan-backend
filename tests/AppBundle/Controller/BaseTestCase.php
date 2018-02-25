<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class BaseTestCase extends WebTestCase
{
    const USERNAME = "test-admin";
    const PASSWORD = "pass-admin";
        
    /**
     * @return Client
     */
    protected function createAdminAuthorizedClient()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('_submit')->form(array(
            '_username'  => self::USERNAME,
            '_password'  => self::PASSWORD,
        ));
        
        $client->submit($form);
        return $client;
    }
}
