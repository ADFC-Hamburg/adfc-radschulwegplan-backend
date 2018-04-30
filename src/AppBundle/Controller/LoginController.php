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

use AppBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// see: https://symfony.com/blog/new-in-symfony-3-3-json-authentication
class LoginController extends FosRestController
{
    /**
     * Login with JSON. Does NOT work with urlencoded parameters.
     *
     * @SWG\Parameter(
     *     name="username",
     *     in="formData",
     *     type="string",
     *     required=true,
     *     description="Username of the user which logs-in."
     * )
     * @SWG\Parameter(
     *     name="password",
     *     in="formData",
     *     type="string",
     *     required=true,
     *     description="Password of the user which logs-in."
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Returns the User with username={username}",
     *     @Model(type=User::class)
     * )
     * @SWG\Response(
     *     response=401,
     *     description="Invalid Credentials",
     * )
     * @Rest\Post("/api/v1/login")
     */
    public function loginAction(Request $request)
    {
        $userName = $request->get('username');
        $user = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->findOneBy(array('username' => $userName));

        if (!$user) {
            return new View('user not found', Response::HTTP_NOT_FOUND);
        }

        return $user;
    }
}
