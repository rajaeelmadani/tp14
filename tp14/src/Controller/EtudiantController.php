<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\TranslatorInterface;
use App\Entity\Etudiant;
use App\Form\EtudiantType;
class EtudiantController extends AbstractController
{
    /**
     * @Route("/form", name="form")
     */
    public function form(Request $request) 
    {
		  $e= new Etudiant();
		  $form= $this->createForm(EtudiantType::class, $e);
		  $form->handleRequest($request);
       
		 if($form->isSubmitted() && $form->isValid()){
			$entityManager=$this->getDoctrine()->getManager();
			 
		   $entityManager->persist($e);
		   $entityManager->flush();
		     $this->addFlash("info","L'étudiant a été ajouté avec succès");
		 	 }
		   return $this->render('form/index.html.twig', [
              'form' => $form->createView()
         ]);
    }
}
