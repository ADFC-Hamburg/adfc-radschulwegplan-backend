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

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\School;
use AppBundle\Entity\SchoolClass;
use AppBundle\Entity\User;
use AppBundle\Exception\SchoolSchoolClassMismatchException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EntityUserTest extends KernelTestCase
{
    public function testInheritedSetAndGetUser()
    {
        $user = new User();
        $user->setUsername('demo-user1');
        $this->assertSame('demo-user1', $user->getUsername());

        $user->setEmail('demo-user1@example.com');
        $this->assertSame('demo-user1@example.com', $user->getEmail());

        $user->setEnabled(true);
        $this->assertTrue($user->isEnabled());

        $user->setEnabled(false);
        $this->assertFalse($user->isEnabled());
    }

    public function testSchoolGeterAndSeter()
    {
        $user = new User();
        $s = new School();
        $s->setName('hiho');
        $this->assertSame($user->getSchool(), null);
        $this->assertSame($user->getSchoolClass(), null);
        $this->assertFalse($user->hasSchool());
        $user->setSchool($s);
        $this->assertSame($s, $user->getSchool());
        $this->assertTrue($user->hasSchool());
    }

    public function testSchoolClassGeterAndSeter()
    {
        $user = new User();
        $s = new School();
        $s->setName('hiho');
        $sc = new SchoolClass();
        $sc->setName('hiho');
        $sc->setSchool($s);
        $this->assertFalse($user->hasSchool());
        $user->setSchoolClass($sc);
        $this->assertSame($s, $user->getSchool());
        $this->assertSame($sc, $user->getSchoolClass());
        $this->assertTrue($user->hasSchool());
    }

    public function testSchoolSeterFailure()
    {
        $s1 = $this->createMock(School::class);
        $s1->expects($this->any())
           ->method('getId')
          ->will($this->returnValue(42));
        $s2 = $this->createMock(School::class);
        $s2->expects($this->any())
           ->method('getId')
          ->will($this->returnValue(17));

        $sc = new SchoolClass();
        $sc->setSchool($s1);
        $user = new User();
        $user->setSchoolClass($sc);
        $this->expectException(SchoolSchoolClassMismatchException::class);
        $user->setSchool($s2);
    }

    public function testSchoolSeterOkay()
    {
        $s1 = $this->createMock(School::class);
        $s1->expects($this->any())
           ->method('getId')
           ->will($this->returnValue(42));

        $sc = new SchoolClass();
        $sc->setSchool($s1);
        $user = new User();
        $user->setSchoolClass($sc);
        $user->setSchool($s1);
        $this->assertSame($s1, $user->getSchool());
        $this->assertSame($sc, $user->getSchoolClass());
    }
}
