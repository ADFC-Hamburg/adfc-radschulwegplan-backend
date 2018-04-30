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

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class JSONLoginTest extends WebTestCase
{
    public $fixtures = null;

    public function setUp()
    {
        $fixturesArray = array(
            'AppBundle\DataFixtures\UserFixtures',
        );
        $this->fixtures = $this->loadFixtures(
            $fixturesArray,
            null,
            'doctrine',
            ORMPurger::PURGE_MODE_TRUNCATE)->getReferenceRepository();
    }

    public function testFormLogin()
    {
        $server = array('HTTP_CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json');

        $client = static::createClient();
        $client->request('POST',
        '/api/v1/login',
        array(
            'username' => 'test-admin',
            'password' => 'pass-admin',
        ),
        array(),
        $server,
        '{ "username": "test-admin", "password": "pass-admin" }'
        );

        $text = $client->getResponse()->getContent();
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertContains('ROLE_ADMIN', $text);
    }
}
