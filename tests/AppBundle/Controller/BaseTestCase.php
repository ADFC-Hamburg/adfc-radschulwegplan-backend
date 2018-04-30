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

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

abstract class BaseTestCase extends WebTestCase
{
    const ADMIN_USERNAME = 'test-admin';
    const ADMIN_PASSWORD = 'pass-admin';

    const STUDENT1_USERNAME = 'test-1student';
    const STUDENT1_PASSWORD = 'pass-student';

    /**
     * @return Client
     */
    protected function createAdminAuthorizedClient()
    {
        return $this->login(self::ADMIN_USERNAME, self::ADMIN_PASSWORD);
    }

    /**
     * @return Client
     */
    protected function createStudent1AuthorizedClient()
    {
        return $this->login(self::STUDENT1_USERNAME, self::STUDENT1_PASSWORD);
    }

    /**
     * @return Client
     */
    protected function createStudent2AuthorizedClient()
    {
        return $this->login(self::STUDENT2_USERNAME, self::STUDENT2_PASSWORD);
    }

    /**
     * Login to Symfony with FosUser Bundle and test if login is successfull.
     *
     * @param string $username Username
     * @param string $password Password
     *
     * @return Client
     */
    private function login(String $username, String $password)
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('_submit')->form(array(
            '_username' => $username,
            '_password' => $password,
        ));

        $client->submit($form);

        $this->assertSame(302, $client->getResponse()->getStatusCode());
        // if not successfull user is redirected to /login
        $this->assertNotContains('login', $client->getResponse()->getTargetUrl());

        return $client;
    }
}
