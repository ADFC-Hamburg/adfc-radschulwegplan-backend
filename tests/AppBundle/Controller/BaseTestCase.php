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
    const USERNAME = 'test-admin';
    const PASSWORD = 'pass-admin';

    /**
     * @return Client
     */
    protected function createAdminAuthorizedClient()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('_submit')->form(array(
            '_username' => self::USERNAME,
            '_password' => self::PASSWORD,
        ));

        $client->submit($form);

        return $client;
    }
}
