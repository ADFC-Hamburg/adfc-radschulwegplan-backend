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

namespace Tests\AppBundle\Controller\SchoolClassController;

class GetOneTest extends SchoolClassControllerBaseTest
{
    public function test5aGetOne()
    {
        $client = $this->createAuthorizedClient('adfc-admin-user');
        $id = $this->fixtures->getReference('class-gsh-5a')->getId();
        $schoolId = $this->fixtures->getReference('gsh-school')->getId();
        $crawler = $client->request('GET', self::API_PATH.'/'.$id);
        $this->assertStatusCode(200, $client);
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertSame('5a', $data['name']);
        $this->assertSame($id, $data['id']);
        $this->assertSame($schoolId, $data['school']['id']);
    }
}
