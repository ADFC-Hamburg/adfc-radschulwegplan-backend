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

namespace Tests\AppBundle\Controller\UserController;

class UserContreollerGetOneTest extends UserControllerBaseTest
{
    public function testGetOneAsAdmin()
    {
        $client = $this->createAuthorizedClient('adfc-admin-user');
        $id = $this->getFixtureFromRef('adfc-admin-user')->getId();
        $client->request('GET', self::API_PATH.'/'.$id);
        $this->assertStatusCode(200, $client);
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertAdminUserCompare('adfc-admin-user', $data);
    }

    public function testGetOneAsStudent()
    {
        $client = $this->createAuthorizedClient('student2-user');
        $id = $this->getFixtureFromRef('adfc-admin-user')->getId();
        $client->request('GET', self::API_PATH.'/'.$id);
        $this->assertStatusCode(200, $client);
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertNormalUserCompare('adfc-admin-user', $data);
    }
}
