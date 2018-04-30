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

use AppBundle\Entity\User;
use Tests\AppBundle\Controller\ControllerBaseTestCase;

abstract class UserControllerBaseTest extends ControllerBaseTestCase
{
    const API_PATH = '/api/v1/user';

    public function setUp()
    {
        $this->loadFixturesWithTrunc(array(
            'AppBundle\DataFixtures\SchoolUserFixtures',
        ));
    }

    public function assertNormalUserCompare(string $userRef, $data)
    {
        // @var User $user
        $user = $this->getFixtureFromRef($userRef);
        $this->assertArrayHasKey('id', $data);

        $this->assertArrayNotHasKey('email', $data);
        $this->assertArrayNotHasKey('username', $data);
        $this->assertArrayNotHasKey('password', $data);
        $this->assertArrayNotHasKey('username_canonical', $data);
        $this->assertArrayNotHasKey('email_canonical', $data);

        self::assertSame($user->getId(), $data['id'], 'Id not equal on user ' + $userRef);
    }

    public function assertAdminUserCompare(string $userRef, $data)
    {
        // @var User $user
        $user = $this->getFixtureFromRef($userRef);

        $this->assertArrayHasKey('username', $data);
        $this->assertArrayHasKey('email', $data);
        $this->assertArrayHasKey('id', $data);

        $this->assertArrayNotHasKey('password', $data);
        $this->assertArrayNotHasKey('username_canonical', $data);
        $this->assertArrayNotHasKey('email_canonical', $data);

        self::assertSame($user->getUserName(), $data['username'], 'Username not equal on user ' + $userRef);
        self::assertSame($user->getEMail(), $data['email'], 'Email not equal on user ' + $userRef);
        self::assertSame($user->getId(), $data['id'], 'Id not equal on user ' + $userRef);
    }
}
