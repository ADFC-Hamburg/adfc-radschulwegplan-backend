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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends FOSRestController
{
    /**
     * @Rest\Get("/api/v1/user")
     */
    public function getAllAction()
    {
        $restresult = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
        if (null === $restresult) {
            return new View('there are no users exist', Response::HTTP_NOT_FOUND);
        }

        return $restresult;
    }

    /**
     * @Rest\Get("/api/v1/user/{id}")
     */
    public function idAction($id)
    {
        $singleresult = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
        if (null === $singleresult) {
            return new View('user not found', Response::HTTP_NOT_FOUND);
        }

        return $singleresult;
    }

    /**
     * @Rest\Put("/user/{id}")
     */
    public function updateAction($id, Request $request)
    {
        $name = $request->get('name');
        $role = $request->get('role');
        $sn = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
        if (empty($user)) {
            return new View('user not found', Response::HTTP_NOT_FOUND);
        } elseif (!empty($name) && !empty($role)) {
            $user->setName($name);
            $user->setRole($role);
            $sn->flush();

            return new View('User Updated Successfully', Response::HTTP_OK);
        } elseif (empty($name) && !empty($role)) {
            $user->setRole($role);
            $sn->flush();

            return new View('role Updated Successfully', Response::HTTP_OK);
        } elseif (!empty($name) && empty($role)) {
            $user->setName($name);
            $sn->flush();

            return new View('User Name Updated Successfully', Response::HTTP_OK);
        }

        return new View('User name or role cannot be empty', Response::HTTP_NOT_ACCEPTABLE);
    }
}
