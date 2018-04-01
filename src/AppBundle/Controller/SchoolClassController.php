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
use AppBundle\Entity\SchoolClass;
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
 * @Route("/api/v1/school_class")
 */
class SchoolClassController extends FosRestController
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
     * Get all schoolClasses of a school.
     *
     * @return SchoolClass[] of a school, every schoolClass is public
     *
     * @param int $schoolId id of the school
     *
     * @SWG\Parameter(
     *     name="schoolId",
     *     in="path",
     *     type="integer",
     *     description="id of the school"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Returns all schoolsClass, every schoolClass is public",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref="#/definitions/SchoolClass")
     *     )
     * )
     * @Rest\Get("/fromSchool/{schoolId}")
     */
    public function getAllFromSchoolAction($schoolId)
    {
        $restresult = $this->getDoctrine()->getRepository('AppBundle:SchoolClass')->findAllFromSchool($schoolId);
        if (null === $restresult) {
            $restresult = array();
        }

        return $restresult;
    }

    /**
     * Get one schoolClass.
     *
     * @param int $classId id of the schoolClass
     *
     * @return School[] SchoolClass with id=$id
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns one schoolClass with id={id}",
     *     @Model(type=SchoolClass::class)
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="integer",
     *     description="id of the schoolClass"
     * )
     * @Rest\Get("/{id}")
     */
    public function getOneAction($id)
    {
        $singleresult = $this->getDoctrine()->getRepository('AppBundle:SchoolClass')->find($id);
        if (null === $singleresult) {
            return new View('SchoolClass not found', Response::HTTP_NOT_FOUND);
        }

        return $singleresult;
    }

    /**
     * Create schoolClass.
     *
     * @param Request $request newObjectRequest
     *
     * @return SchoolClass SchoolClass just created
     *
     * @SWG\Parameter(
     *     name="name",
     *     in="formData",
     *     type="string",
     *     required=true,
     *     description="The schoolClass name"
     * )
     * @SWG\Parameter(
     *     name="schoolId",
     *     in="formData",
     *     type="integer",
     *     required=true,
     *     description="The school"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Returns one SchoolClass with id",
     *     @Model(type=SchoolClass::class)
     * )
     * @SWG\Response(
     *     response=403,
     *     description="Returns 403 HTTP if the user has no permission",
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Returns 400 HTTP if values are wrong",
     * )
     * @Rest\Post("")
     */
    public function newAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $okay = false;
        $schoolId = $request->get('schoolId');
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $okay = true;
        } elseif ($this->get('security.authorization_checker')->isGranted('ROLE_SCHOOL_ADMIN')) {
            $okay = true;
            if ($schoolId != $user->getSchool()->getId()) {
                return new View('schoolAdmin can only create schoolClasses for his school', Response::HTTP_FORBIDDEN);
            }
        }
        if (false == $okay) {
            return new View('you need to be admin or schoolAdmin', Response::HTTP_FORBIDDEN);
        }
        $name = $request->get('name');
        if (empty($name)) {
            return new View('please specify a name', Response::HTTP_BAD_REQUEST);
        }

        if (empty($schoolId)) {
            return new View('please specify a schoolId', Response::HTTP_BAD_REQUEST);
        }
        $school = $this->getDoctrine()->getRepository('AppBundle:School')->find($schoolId);
        if (is_null($school)) {
            return new View('please specify a schoolId', Response::HTTP_BAD_REQUEST);
        }
        $em = $this->getDoctrine()->getManager();
        $data = new SchoolClass();
        $data->setName($name);
        $data->setSchool($school);
        $data->setCreatedNow($user);
        $em->persist($data);
        $em->flush();

        return $data;
    }

    /**
     * Modify SchoolClass.
     *
     * @param int     $id      id of the schoolClass
     * @param Request $request newObjectRequest
     *
     * @return SchoolClass SchoolClass just modified
     *
     * @SWG\Parameter(
     *     name="name",
     *     in="formData",
     *     type="string",
     *     required=true,
     *     description="The school Class name e.g '5c'"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Returns one SchoolClass with id",
     *     @Model(type=SchoolClass::class)
     * )
     * @SWG\Response(
     *     response=403,
     *     description="Returns 403 HTTP if the user has no permission",
     * )
     * @SWG\Response(
     *     response=404,
     *     description="Returns 404 HTTP if entry does not exists",
     * )
     * @Rest\Put("/{id}")
     */
    public function updateAction($id, Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if (!(
            $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') or
            $this->get('security.authorization_checker')->isGranted('ROLE_SCHOOL_ADMIN'))) {
            return new View('you need to be admin or school-admin', Response::HTTP_FORBIDDEN);
        }
        $name = $request->get('name');
        if (empty($name)) {
            return new View('class not found', Response::HTTP_BAD_REQUEST);
        } // else
        $this->logger->info('UPDATE START');
        $em = $this->getDoctrine()->getManager();
        $entry = $this->getDoctrine()->getRepository('AppBundle:SchoolClass')->find($id);
        if (empty($entry)) {
            return new View('class not found', Response::HTTP_NOT_FOUND);
        }
        // else
        if ($this->get('security.authorization_checker')->isGranted('ROLE_SCHOOL_ADMIN') and
        ($entry->getSchool()->getId() != $user->getSchool()->getId())) {
            return new View('school-admin is not allowed to modify classes of different schools', Response::HTTP_FORBIDDEN);
        }
        $this->logger->info('name: ', array($name));
        $entry->setName($name);
        $entry->setChangedNow($user);
        $em->persist($entry);
        $em->flush();

        $this->logger->info('UPDATE END');

        return $entry;
    }

    /**
     * Delete one SchoolClass.
     *
     * @param int $id id of the schoolClass
     *
     * @return View HTTP Response 200 (success), 403 (forbidden), 404 (not found)
     *
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="integer",
     *     description="The id of the schoolClass"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Returns 200 HTTP if sucessfull",
     * )
     * @SWG\Response(
     *     response=403,
     *     description="Returns 403 HTTP if the user has no permission",
     * )
     * @SWG\Response(
     *     response=404,
     *     description="Returns 404 HTTP if entry does not exists",
     * )
     * @Rest\Delete("/{id}")
     */
    public function deleteAction($id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return new View('you need to be admin', Response::HTTP_FORBIDDEN);
        }
        $em = $this->getDoctrine()->getManager();
        $entry = $this->getDoctrine()->getRepository('AppBundle:SchoolClass')->find($id);
        if (empty($entry)) {
            return new View('entry not found', Response::HTTP_NOT_FOUND);
        }
        $em->remove($entry);
        $em->flush();

        return new View('deleted successfully', Response::HTTP_OK);
    }
}
