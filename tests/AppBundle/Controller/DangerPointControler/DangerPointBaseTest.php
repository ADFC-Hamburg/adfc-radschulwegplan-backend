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

namespace Tests\AppBundle\Controller\DangerPointControler;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Liip\FunctionalTestBundle\Test\WebTestCase;

abstract class DangerPointBaseTest extends WebTestCase
{
    const API_PATH = '/api/v1/danger_point';

    public $fixtures = null;

    public function setUp()
    {
        $fixturesArray = array(
            'AppBundle\DataFixtures\DangerPointFixtures',
        );
        $this->fixtures = $this->loadFixtures(
            $fixturesArray,
            null,
            'doctrine',
            ORMPurger::PURGE_MODE_TRUNCATE)->getReferenceRepository();
    }

    /**
     * @return Client
     */
    protected function createAuthorizedClient(string $userRef)
    {
        $this->loginAs($fixtures->getReference($userRef), 'main');

        return $this->makeClient();
    }
}
