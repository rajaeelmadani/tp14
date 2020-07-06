<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Etudiant;
class ListeController extends AbstractController
{
    /**
     * @Route("/liste", name="liste")
     */
    public function index()
    {
		$etd = $this->getDoctrine()->getRepository(Etudiant::class)->findAll();
	return $this->render('liste/index.html.twig',['etd'=>$etd]);
    }
}
