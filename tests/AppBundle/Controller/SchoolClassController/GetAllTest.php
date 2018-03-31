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

class GetAllTest extends SchoolClassControllerBaseTest
{
    public function testGshAll()
    {
        $client = $this->createAuthorizedClient('adfc-admin-user');
        $schoolId = $this->fixtures->getReference('gsh-school')->getId();
        $id = $this->fixtures->getReference('class-gsh-5a')->getId();

        $crawler = $client->request('GET', self::FROM_SCHOOL_API_PATH.$schoolId);
        $this->assertStatusCode(200, $client);
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertSame(4, count($data));
        $this->assertSame('5a', $data[0]['name']);
        $this->assertSame($id, $data[0]['id']);
        $this->assertSame($schoolId, $data[0]['school']['id']);
    }
}
