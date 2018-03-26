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
