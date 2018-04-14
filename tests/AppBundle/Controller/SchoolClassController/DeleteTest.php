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

class DelteteTest extends SchoolClassControllerBaseTest
{
    private $url5b = null;

    public function testAdminDelete()
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $classes = $em->getRepository(SchoolClass::class)
                     ->findByName('5b');
        $schoolId = $this->fixtures->getReference('gsh-school')->getId();
        $this->assertCount(1, $classes);
        $client = $this->createAuthorizedClient('adfc-admin-user');
        $client->request(
            'DELETE',
            $this->url5bGsh()
        );
        $this->assertStatusCode(200, $client);
        $classes = $em->getRepository(SchoolClass::class)
                     ->findByName('5b');

        $this->assertCount(0, $classes);
    }

    public function testSchoolAdminDelete()
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $classes = $em->getRepository(SchoolClass::class)
                     ->findByName('5b');
        $schoolId = $this->fixtures->getReference('gsh-school')->getId();
        $this->assertCount(1, $classes);
        $client = $this->createAuthorizedClient('school1-admin-user');
        $client->request(
            'DELETE',
            $this->url5bGsh()
        );
        $this->assertStatusCode(200, $client);
        $classes = $em->getRepository(SchoolClass::class)
                     ->findByName('5b');

        $this->assertCount(0, $classes);
    }

    public function testDeleteWithInvalidSchoolId()
    {
        $client = $this->createAuthorizedClient('adfc-admin-user');
        $client->request(
            'DELETE',
            self::API_PATH.'/9999999'
        );
        $this->assertStatusCode(404, $client);
    }

    public function testDeleteFailByStudent()
    {
        $client = $this->createAuthorizedClient('student1-user');
        $client->request(
            'DELETE',
            $this->url5bGsh()
        );
        $this->assertStatusCode(403, $client);
    }

    public function testDeleteFailByReviewer()
    {
        $client = $this->createAuthorizedClient('school2-admin-user');
        $client->request(
            'DELETE',
            $this->url5bGsh()
        );
        $this->assertStatusCode(403, $client);
    }

    private function url5bGsh()
    {
        if (is_null($this->url5b)) {
            $this->url5b = self::API_PATH.
                '/'.
                $this->fixtures->getReference('class-gsh-5b')->getId();
        }

        return $this->url5b;
    }
}
