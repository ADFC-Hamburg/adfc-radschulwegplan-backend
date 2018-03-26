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

use AppBundle\Entity\School;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api/v1/school")
 */
class SchoolController extends FosRestController
{
    /** @var LoggerInterface $logger Logger */
    private $logger;

    /**
     * @param LoggerInterface $logger LoggerInterface is created by dependency injection
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Get all schools.
     *
     * @return School[] all schools, every school is public
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns all schools, every school is public",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref="#/definitions/School")
     *     )
     * )
     * @Rest\Get("")
     */
    public function getAllAction()
    {
        $restresult = $this->getDoctrine()->getRepository('AppBundle:School')->findAll();
        if (null === $restresult) {
            $restresult = array();
        }

        return $restresult;
    }

    /**
     * Get one school.
     *
     * @param int $id id of the school
     *
     * @return School[] School with id=$id
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns one school with id={id}",
     *     @Model(type=School::class)
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="integer",
     *     description="id of the school"
     * )
     * @Rest\Get("/{id}")
     */
    public function getOneAction($id)
    {
        $singleresult = $this->getDoctrine()->getRepository('AppBundle:School')->find($id);
        if (null === $singleresult) {
            return new View('point not found', Response::HTTP_NOT_FOUND);
        }

        return $singleresult;
    }

    /**
     * Create school.
     *
     * @param Request $request newObjectRequest
     *
     * @return School School just created
     *
     * @SWG\Parameter(
     *     name="name",
     *     in="formData",
     *     type="string",
     *     required=false,
     *     description="The school name"
     * )
     * @SWG\Parameter(
     *     name="street",
     *     in="formData",
     *     type="string",
     *     required=false,
     *     description="Street of the school including housenumber"
     * )
     * @SWG\Parameter(
     *     name="postalcode",
     *     in="formData",
     *     type="string",
     *     required=false,
     *     description="Postalcode"
     * )
     * @SWG\Parameter(
     *     name="place",
     *     in="formData",
     *     type="string",
     *     required=false,
     *     description="Place of the school"
     * )
     * @SWG\Parameter(
     *     name="webpage",
     *     in="formData",
     *     type="string",
     *     required=false,
     *     description="The Webpage of the school"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Returns one School with id",
     *     @Model(type=School::class)
     * )
     * @SWG\Response(
     *     response=403,
     *     description="Returns 403 HTTP if the user has no permission",
     *     @Model(type=School::class)
     * )
     * @SWG\Response(
     *     response=404,
     *     description="Returns 404 HTTP if entry does not exists",
     *     @Model(type=School::class)
     * )
     * @Rest\Post("")
     */
    public function newAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return new View('you need to be admin', Response::HTTP_FORBIDDEN);
        }
        $data = new School();
        $name = $request->get('name');
        $data->setName($name);
        $street = $request->get('street');
        $data->setStreet($street);
        $pc = $request->get('postalcode');
        $data->setPostalCode($pc);
        $place = $request->get('place');
        $data->setPlace($place);
        $webpage = $request->get('webpage');
        $data->setWebpage($webpage);
        $data->setCreatedNow($user);
        $em = $this->getDoctrine()->getManager();
        $newObj = $em->merge($data);
        $em->flush();

        return $newObj;
    }

    /**
     * Modify School.
     *
     * @param int     $id      id of the school
     * @param Request $request newObjectRequest
     *
     * @return School School just modified
     *
     * @SWG\Parameter(
     *     name="name",
     *     in="formData",
     *     type="string",
     *     required=true,
     *     description="The school name"
     * )
     * @SWG\Parameter(
     *     name="street",
     *     in="formData",
     *     type="string",
     *     required=false,
     *     description="Street of the school including housenumber"
     * )
     * @SWG\Parameter(
     *     name="postalcode",
     *     in="formData",
     *     type="string",
     *     required=false,
     *     description="Postalcode"
     * )
     * @SWG\Parameter(
     *     name="place",
     *     in="formData",
     *     type="string",
     *     required=false,
     *     description="Place of the school"
     * )
     * @SWG\Parameter(
     *     name="webpage",
     *     in="formData",
     *     type="string",
     *     required=false,
     *     description="The Webpage of the school"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Returns one School with id",
     *     @Model(type=School::class)
     * )
     * @SWG\Response(
     *     response=403,
     *     description="Returns 403 HTTP if the user has no permission",
     *     @Model(type=School::class)
     * )
     * @SWG\Response(
     *     response=404,
     *     description="Returns 404 HTTP if entry does not exists",
     *     @Model(type=School::class)
     * )
     * @Rest\Put("/{id}")
     */
    public function updateAction($id, Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return new View('you need to be admin', Response::HTTP_FORBIDDEN);
        }
        $this->logger->info('UPDATE START');
        $em = $this->getDoctrine()->getManager();
        $entry = $this->getDoctrine()->getRepository('AppBundle:School')->find($id);
        if (empty($entry)) {
            return new View('point not found', Response::HTTP_NOT_FOUND);
        }
        // else
        $changed = false;

        $name = $request->get('name');
        if (!(empty($name))) {
            $this->logger->info('name: ', array($name));
            $entry->setName($name);
            $changed = true;
        }

        $street = $request->get('street');
        if (!(empty($street))) {
            $entry->setStreet($street);
            $changed = true;
        }

        $postalcode = $request->get('postalcode');
        if (!(empty($postalcode))) {
            $entry->setPostalCode($postalcode);
            $changed = true;
        }

        $place = $request->get('place');
        if (!(empty($place))) {
            $entry->setPlace($place);
            $changed = true;
        }

        $web = $request->get('webpage');
        if (!(empty($web))) {
            $entry->setWebpage($web);
            $changed = true;
        }

        if ($changed) {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $entry->setChangedNow($user);
            $em->persist($entry);
            $em->flush();
        }
        $this->logger->info('UPDATE END');

        return $entry;
    }

    /**
     * Delete one School.
     *
     * @param int $id id of the school
     *
     * @return View HTTP Response 200 (success), 403 (forbidden), 404 (not found)
     *
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="integer",
     *     description="The id of the school"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Returns 200 HTTP if sucessfull",
     *     @Model(type=School::class)
     * )
     * @SWG\Response(
     *     response=403,
     *     description="Returns 403 HTTP if the user has no permission",
     *     @Model(type=School::class)
     * )
     * @SWG\Response(
     *     response=404,
     *     description="Returns 404 HTTP if entry does not exists",
     *     @Model(type=School::class)
     * )
     * @Rest\Delete("/{id}")
     */
    public function deleteAction($id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return new View('you need to be admin', Response::HTTP_FORBIDDEN);
        }
        $em = $this->getDoctrine()->getManager();
        $entry = $this->getDoctrine()->getRepository('AppBundle:School')->find($id);
        if (empty($entry)) {
            return new View('entry not found', Response::HTTP_NOT_FOUND);
        }
        $em->remove($entry);
        $em->flush();

        return new View('deleted successfully', Response::HTTP_OK);
    }
}
