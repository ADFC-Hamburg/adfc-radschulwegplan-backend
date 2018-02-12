<?php
namespace AppBundle\Controller;
 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\User;

class UserController extends FOSRestController
{

    /**
     * @Rest\Get("/api/v1/user")
     */
    public function getAllAction()
    {
      $restresult = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
        if ($restresult === null) {
          return new View("there are no users exist", Response::HTTP_NOT_FOUND);
     }
        return $restresult;
    }
    
    /**
     * @Rest\Get("/api/v1/user/{id}")
     */
    public function idAction($id)
     {
      $singleresult = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
      if  ($singleresult === null) {
          return new View("user not found", Response::HTTP_NOT_FOUND);
       }
    return $singleresult;
}
/**
 * @Rest\Put("/user/{id}")
 */
 public function updateAction($id,Request $request)
 { 
 $data = new User;
 $name = $request->get('name');
 $role = $request->get('role');
 $sn = $this->getDoctrine()->getManager();
 $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
if (empty($user)) {
   return new View("user not found", Response::HTTP_NOT_FOUND);
 } 
elseif(!empty($name) && !empty($role)){
   $user->setName($name);
   $user->setRole($role);
   $sn->flush();
   return new View("User Updated Successfully", Response::HTTP_OK);
 }
elseif(empty($name) && !empty($role)){
   $user->setRole($role);
   $sn->flush();
   return new View("role Updated Successfully", Response::HTTP_OK);
}
elseif(!empty($name) && empty($role)){
 $user->setName($name);
 $sn->flush();
 return new View("User Name Updated Successfully", Response::HTTP_OK); 
}
else return new View("User name or role cannot be empty", Response::HTTP_NOT_ACCEPTABLE); 
 }
}
