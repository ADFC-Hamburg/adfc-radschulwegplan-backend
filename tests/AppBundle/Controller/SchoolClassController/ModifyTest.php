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

use AppBundle\Entity\SchoolClass;

class ModifyTest extends SchoolClassControllerBaseTest
{
    private $url6a = null;

    public function testModifyWithoutName()
    {
        $client = $this->createAuthorizedClient('adfc-admin-user');
        $client->request(
            'PUT',
            $this->url6aGsh(),
            array(
            )
        );
        $this->assertStatusCode(400, $client);
    }

    public function testAdminModify()
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $classes = $em->getRepository(SchoolClass::class)
                     ->findByName('5f');
        $schoolId = $this->fixtures->getReference('gsh-school')->getId();
        $this->assertCount(0, $classes);
        $client = $this->createAuthorizedClient('adfc-admin-user');
        $client->request(
            'PUT',
            $this->url6aGsh(),
            array(
                'name' => '5f',
            )
        );
        $this->assertStatusCode(200, $client);
        $data = json_decode($client->getResponse()->getContent(), true);
        $id = $data['id'];
        $this->assertSame('5f', $data['name']);
        $classes = $em->getRepository(SchoolClass::class)
                     ->findByName('5f');

        $this->assertCount(1, $classes);
        $cl = $classes[0];
        $this->assertSame('5f', $cl->getName());
        $this->assertSame($id, $cl->getId());
        $this->assertSame($schoolId, $cl->getSchool()->getId());
    }

    public function testSchoolAdminModify()
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $classes = $em->getRepository(SchoolClass::class)
                     ->findByName('5k');
        $this->assertCount(0, $classes);
        $client = $this->createAuthorizedClient('school1-admin-user');
        $schoolId = $this->fixtures->getReference('gsh-school')->getId();
        $client->request(
            'PUT',
            $this->url6aGsh(),
            array(
                'name' => '5k',
            )
        );
        $this->assertStatusCode(200, $client);

        $data = json_decode($client->getResponse()->getContent(), true);
        $id = $data['id'];
        $this->assertSame('5k', $data['name']);
        $this->assertSame($schoolId, $data['school']['id']);
        $classes = $em->getRepository(SchoolClass::class)
                     ->findByName('5k');

        $this->assertCount(1, $classes);
        $cl = $classes[0];
        $this->assertSame('5k', $cl->getName());
        $this->assertSame($id, $cl->getId());
        $this->assertSame($schoolId, $cl->getSchool()->getId());
    }

    public function testModifyWithInvalidSchoolId()
    {
        $client = $this->createAuthorizedClient('adfc-admin-user');
        $client->request(
            'PUT',
            self::API_PATH.'/9999999',
            array(
                'name' => '5f',
            )
        );
        $this->assertStatusCode(404, $client);
    }

    public function testModifyFailByStudent()
    {
        $client = $this->createAuthorizedClient('student1-user');
        $client->request(
            'PUT',
            $this->url6aGsh(),
            array(
                'name' => '5g',
            )
        );
        $this->assertStatusCode(403, $client);
    }

    public function testModifyFailByReviewer()
    {
        $client = $this->createAuthorizedClient('school2-admin-user');
        $client->request(
            'PUT',
            $this->url6aGsh(),
            array(
                'name' => '5g',
            )
        );
        $this->assertStatusCode(403, $client);
    }

    private function url6aGsh()
    {
        if (is_null($this->url6a)) {
            $this->url6a = self::API_PATH.
                '/'.
                $this->fixtures->getReference('class-gsh-6a')->getId();
        }

        return $this->url6a;
    }
}
