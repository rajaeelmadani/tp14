<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Etudiant;
use Doctrine\ORM\EntityManagerInterface;

class DetailController extends AbstractController
{
    /**
     * @Route("/detail/{id}", name="detail")
     */
    public function index($id)
    {
		 $e = $this->getDoctrine()
        ->getRepository(Etudiant::class)
        ->find($id);
        return $this->render('detail/index.html.twig', [
            'e' => $e
        ]);
    }
	/**
     * @Route("/detail/supprimer/{id}", name="supprimer")
     */
public function supprimer($id) {
	
	 
		$repository = $this->getDoctrine()->getManager();
		$etd=$repository->getRepository(Etudiant::class);
		$e=	$etd->find($id);
		
		 
		 $repository->remove($e);		
		$repository->flush();
		
	 
		$this->addFlash("info","L'étudiant $id a été supprimé avec succès");
		return $this->redirectToRoute("liste");	
	}
		/**
     * @Route("/detail/modifier/{id}", name="modifier")
     * Method({"GET","POST"})
     */
public function modifier(Request $request,$id) {
	
	 $e = new Etudiant();
      $e = $this->getDoctrine()->getRepository(Etudiant::class)->find($id);

      $form = $this->createFormBuilder($e)
        ->add('Nom')
            ->add('Prenom')
		    ->add('Sexe', ChoiceType::class, [
    'choices' => [
        'Homme' => 'Homme',
        'Femme' => 'Femme',
    ],
    'expanded' => true,
])
            ->add('Note')
            ->add('Email',EmailType::class)
	->add('Save',SubmitType::class,['label'=>'Enregistrer']) 
       ->getForm(); 

      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()) {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
 
        return $this->redirectToRoute('liste');
		
		     $this->addFlash("info","L'étudiant a été modifié avec succès");
      }

      return $this->render('Etudiant/edit.html.twig', array(
        'form' => $form->createView()
      ));
    }

	 
}
