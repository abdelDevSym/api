<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\View\View; // Utilisation de la vue de FOSRestBundle
use AppBundle\Entity\Users;
use AppBundle\Form\UsersType;


class PlaceController extends FOSRestController
{
	
	/**
     * @Rest\View()
     * @Rest\Get("/users")
     */
    public function getPlacesAction(Request $request)
    {
		
        $places = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Users')
                ->find();
					
			
        /* @var $places Place[] */

        return $places;
    }
	
	/**
     * @Rest\View()
     * @Rest\Get("/users/{id}")
     */
    public function getPlaceAction(Request $request)
    {
        $place = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Users')
                ->findAll($request->get('id')); // L'identifiant en tant que paramétre n'est plus nécessaire
        /* @var $place Place */

        if (empty($place)) {
            return new JsonResponse(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }

		
        return $place;
    }

	
	 /**
     *@Rest\View(statusCode=Response::HTTP_CREATED)
     *@Rest\Post("/users")
	 */	 	 
	 public function postAction(Request $request)
	 {	

	 
		 $data = new Users;
         $form = $this->createForm(UsersType::class, $data);

		 $form->submit($request->request->all());
		 
			if ($form->isValid()) {
				// perform some action...
				 $em = $this->get('doctrine.orm.entity_manager');
				 $em->persist($data);
	             $em->flush();		
				 
				 return $data;
		
			}
			
						   
    }
	

	
	
    

}
