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

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Liip\FunctionalTestBundle\Test\WebTestCase;

abstract class SchoolClassControllerBaseTest extends WebTestCase
{
    const API_PATH = '/api/v1/school_class';
    const FROM_SCHOOL_API_PATH = '/api/v1/school_class/fromSchool/';

    /**
     * @var Fixtures, usefull to get References to the objects
     */
    public $fixtures = null;

    public function setUp()
    {
        $fixturesArray = array(
            'AppBundle\DataFixtures\SchoolClassFixtures',
        );
        $this->fixtures = $this->loadFixtures(
            $fixturesArray,
            null,
            'doctrine',
            ORMPurger::PURGE_MODE_TRUNCATE)->getReferenceRepository();
    }

    public function assertSchoolClassCompare(string $schoolClassRef, $data)
    {
        $dp = $this->fixtures->getReference($schoolClassRef);
        self::assertSame($dp->getId(), $data['id'], 'Id not equal on schoolClass ' + $dangerPointRef);
        self::assertSame($dp->getName(), $data['name'], 'Name not equal on schoolClass ' + $dangerPointRef);
    }

    /**
     * @return Client
     */
    protected function createAuthorizedClient(string $userRef)
    {
        $this->loginAs($this->fixtures->getReference($userRef), 'main');

        return $this->makeClient();
    }
}
