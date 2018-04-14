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

namespace Tests\AppBundle\Controller\DangerPointController;

use Tests\AppBundle\Controller\ControllerBaseTestCase;

abstract class DangerPointBaseTest extends ControllerBaseTestCase
{
    const API_PATH = '/api/v1/danger_point';

    public function setUp()
    {
        $this->loadFixturesWithTrunc(array(
            'AppBundle\DataFixtures\DangerPointFixtures',
        ));
    }

    public function assertDangerPointCompare(string $dangerPointRef, $data)
    {
        $dp = $this->getFixtureFromRef($dangerPointRef);
        self::assertSame($dp->getId(), $data['id'], 'Id not equal on dangerPoint ' + $dangerPointRef);
        self::assertSame($dp->getPos(), $data['pos'], 'Position not equal on dangerPoint ' + $dangerPointRef);
        self::assertSame($dp->getTitle(), $data['title'], 'Title not equal on dangerPoint ' + $dangerPointRef);
        self::assertSame($dp->getDescription(), $data['description'], 'Title not equal on dangerPoint ' + $dangerPointRef);
        self::assertSame($dp->getTypeId(), $data['type_id'], 'Title not equal on dangerPoint ' + $dangerPointRef);
    }
}
