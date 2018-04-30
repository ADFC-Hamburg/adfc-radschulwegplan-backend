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

namespace AppBundle\Controller;

use AppBundle\Entity\DangerType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;

/*

TODO:

* Check paramters
* Test cases in php
* Call API with json
* Roles/Permissions

*/

/**
 * @Route("api/v1/danger_type")
 */
class DangerTypeController extends FOSRestController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Get all DangerTypes.
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the DangerTypes",
     *     )
     * )
     * @Rest\Get("")
     * FIXME Can not set SWG Schema type=array
     */
    public function getAllAction()
    {
        $repo = $this->getDoctrine()->getRepository('AppBundle:DangerType');
        $restresult = $repo->findAll();

        if (0 == count($restresult)) {
            $repo->insertDangerTypes();
            $restresult = $repo->findAll();
        }

        return $restresult;
    }
}
