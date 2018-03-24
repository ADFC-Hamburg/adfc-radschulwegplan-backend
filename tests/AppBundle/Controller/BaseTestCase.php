<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class BaseTestCase extends WebTestCase
{
    const ADMIN_USERNAME = "test-admin";
    const ADMIN_PASSWORD = "pass-admin";

    const STUDENT_USERNAME = "test-student";
    const STUDENT_PASSWORD = "pass-student";

    /**
     * @return Client
     */
    protected function createAdminAuthorizedClient()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('_submit')->form(array(
            '_username'  => self::ADMIN_USERNAME,
            '_password'  => self::ADMIN_PASSWORD,
        ));
        
        $client->submit($form);
        return $client;
    }

    /**
     * @return Client
     */
    protected function createStudentAuthorizedClient()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('_submit')->form(array(
            '_username'  => self::STUDENT_USERNAME,
            '_password'  => self::STUDENT_PASSWORD,
        ));
        
        $client->submit($form);
        return $client;
    }
}
