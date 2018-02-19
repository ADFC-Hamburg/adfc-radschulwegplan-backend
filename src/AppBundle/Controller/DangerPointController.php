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
     * @Rest\Get("/api/v1/danger_point")
     */
    public function getAllAction()
    {       
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $restresult = $this->getDoctrine()->getRepository('AppBundle:DangerPoint')->findAll();
        } else {
            $restresult = ['a'];
        }
        if ($restresult === null) {
            return new View("there are no points exist", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }
    
    /**
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
//        return new View("DangerPoint Added Successfully", Response::HTTP_OK);
    }

    /**
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
