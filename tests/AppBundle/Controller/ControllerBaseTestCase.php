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

namespace Tests\AppBundle\Controller;

use Doctrine\Common\DataFixtures\Executor\AbstractExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

abstract class ControllerBaseTestCase extends WebTestCase
{
    /**
     * @var AbstractExecutor Fixtures, usefull to get References to the objects
     */
    private $fixtures = null;

    /**
     * Load Fixtures with ORM PRUGE_MODE_TRUNCATE.
     *
     * @param array $fixturesArray Fixtures to load
     */
    public function loadFixturesWithTrunc($fixturesArray)
    {
        $this->fixtures = $this->loadFixtures(
            $fixturesArray,
            null,
            'doctrine',
            ORMPurger::PURGE_MODE_TRUNCATE)->getReferenceRepository();
    }

    /**
     * create Authorized Client from User Fixture.
     *
     * @return Client
     */
    protected function createAuthorizedClient(string $userRef)
    {
        $this->loginAs($this->fixtures->getReference($userRef), 'main');

        return $this->makeClient();
    }

    /**
     * Get Fixture Object from Ref.
     *
     * @param $ref String Reference
     *
     * @return object Fixture
     */
    protected function getFixtureFromRef(string $ref)
    {
        return  $this->fixtures->getReference($ref);
    }
}
