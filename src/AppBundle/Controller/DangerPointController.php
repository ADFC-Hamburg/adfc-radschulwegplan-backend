<?php
namespace AppBundle\Controller;
 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\DangerPoint;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
/* 

TODO:

* Check paramters
* Test cases in php
* Call API with json 
* Roles/Permissions

*/


class DangerPointController extends FOSRestController
{

    /**
     * Get all DangerPoints the user is allowed to see
     * 
     * @SWG\Response(
     *     response=200,
     *     description="Returns the DangerPoints of a user",
     *     @SWG\Schema(
     *         type="array",
     *         @Model(type=DangerPoint::class)
     *     )
     * )
     * @Rest\Get("/api/v1/danger_point")
     */
    public function getAllAction()
    {       
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $restresult = $this->getDoctrine()->getRepository('AppBundle:DangerPoint')->findAll();
        } else {
            $restresult = [];
        }
        if ($restresult === null) {
            return new View("there are no points exist", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }
    
    /**
     * Get one DangerPoint
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns one DangerPoint with id={id}",
     *     @Model(type=DangerPoint::class)
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="integer",
     *     description="The id of the point"
     * )
     * @Rest\Get("/api/v1/danger_point/{id}")
     */
    public function idAction($id)
    {
        $singleresult = $this->getDoctrine()->getRepository('AppBundle:DangerPoint')->find($id);
        if  ($singleresult === null) {
            return new View("point not found", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }
    /**
     * Modify DangerPoint
     *
     * @SWG\Parameter(
     *     name="lat",
     *     in="formData",
     *     type="number",
     *     description="The latitude of the point"
     * )
     * @SWG\Parameter(
     *     name="lon",
     *     in="formData",
     *     type="number",
     *     description="The longitude of the point"
     * )
     * @SWG\Parameter(
     *     name="title",
     *     in="formData",
     *     type="string",
     *     description="The title of the point"
     * )
     * @SWG\Parameter(
     *     name="description",
     *     in="formData",
     *     type="string",
     *     description="The description of the point"
     * )
     * @SWG\Parameter(
     *     name="typeId",
     *     in="formData",
     *     type="integer",
     *     required=false,
     *     description="The typeId of the point"
     * )
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="integer",
     *     required=true,
     *     description="The Id of the point (required)"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Returns one DangerPont with id",
     *     @Model(type=DangerPoint::class)
     * )
     * @Rest\Put("/api/v1/danger_point/{id}")
     */
    public function updateAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entry = $this->getDoctrine()->getRepository('AppBundle:DangerPoint')->find($id);
        if (empty($entry)) {
            return new View("point not found", Response::HTTP_NOT_FOUND);
        } 
        // else
        $lat = $request->get('lat');
        $lon = $request->get('lon');
        $chanded=false;
        if (!(empty($lat) || empty($lon))) {
            $entry->setPos(sprintf('SRID=4326;POINT(%f %f)',$lat, $lon));
            $changed=true;
        }
        
        $title = $request->get('title');
        if (!(empty($title))) {
            $entry->setTitle($title);            
            $changed=true;
        }
        $description = $request->get('description');
        if (!(empty($description))) {
            $entry->setTitle($descripion);
            $changed=true;
        }
        $typeId = $request->get('typeId');
        if (!(empty($typeId))) {
            $entry->setTitle($typeId);
            $changed=true;
        }
        if ($changed) {
            $user = $this->get('security.token_storage')->getToken()->getUser();
            $entry->setChangedNow($user);
        }
        $newObj= $em->merge($entry);
        $em->flush();
        return $newObj;
    }

    /**
     * Create new DangerPoint
     *
     * @SWG\Parameter(
     *     name="lat",
     *     in="formData",
     *     type="number",
     *     required=true,
     *     description="The latitude of the point"
     * )
     * @SWG\Parameter(
     *     name="lon",
     *     in="formData",
     *     type="number",
     *     required=true,
     *     description="The longitude of the point"
     * )
     * @SWG\Parameter(
     *     name="title",
     *     in="formData",
     *     required=false,
     *     type="string",
     *     description="The title of the point"
     * )
     * @SWG\Parameter(
     *     name="description",
     *     in="formData",
     *     type="string",
     *     required=false,
     *     description="The description of the point; can contain line breaks"
     * )
     * @SWG\Parameter(
     *     name="typeId",
     *     in="formData",
     *     type="integer",
     *     required=true,
     *     description="The typeId of the point"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Returns one DangerPoint with id",
     *     @Model(type=DangerPoint::class)
     * )
     * @Rest\Post("/api/v1/danger_point/")
     */
    public function postAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $data = new DangerPoint;
        $lat = $request->get('lat');
        $lon = $request->get('lon');
        $title = $request->get('title');
        $description = $request->get('description');
        $typeId = $request->get('typeId');
        if(empty($lat) || empty($lon) || empty($typeId))
            {
                return new View("NULL VALUES ARE NOT ALLOWED".$lat, Response::HTTP_NOT_ACCEPTABLE); 
            } 
        $data->setTitle($title);
        $data->setDescription($description);
        $data->setTypeId($typeId);
        $data->setPos(sprintf('SRID=4326;POINT(%f %f)',$lat, $lon));
        $data->setCreatedNow($user);
        
        $em = $this->getDoctrine()->getManager();
        $newObj= $em->merge($data);
        $em->flush();
        return $newObj;
    }

    /**
     * Delete one DangerPoint
     *
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="integer",
     *     description="The id of the point"
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Returns the DangerPoint with the given id",
     *     @Model(type=DangerPoint::class)
     * )
     * @Rest\Delete("/api/v1/danger_point/{id}")
     */
    public function deleteAction($id)
    {
        $data = new DangerPoint;
        $em = $this->getDoctrine()->getManager();
        $entry = $this->getDoctrine()->getRepository('AppBundle:DangerPoint')->find($id);
        if (empty($entry)) {
            return new View("entry not found", Response::HTTP_NOT_FOUND);
        }
        else {
            $em->remove($entry);
            $em->flush();
        }
        return new View("deleted successfully", Response::HTTP_OK);
    }
}