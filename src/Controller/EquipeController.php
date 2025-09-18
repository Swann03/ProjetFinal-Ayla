<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\EquipeType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Equipe;

final class EquipeController extends AbstractController
{
    #[Route('/equipe', name: 'app_equipe')]
    public function AfficherForm(): Response
    {
        // créer un objet formulaire
    $formEquipe = $this->createForm(EquipeType::class);
    $vars = ['formEquipe' => $formEquipe];

    // faire le rendu de la vue. Envoyer l'objet form
        // depuis le controller
        return $this->render('equipe/index.html.twig', $vars);

    }

    #[Route('/equipe/insert', name: 'app_equipe_insert')]
    public function InsertForm(Request $req, EntityManagerInterface $em): Response
    {
        $equipe = new Equipe();
        // créer un objet formulaire
    $formEquipe = $this->createForm(EquipeType::class);
    $formEquipe->handleRequest($req);
    // faire le rendu de la vue. Envoyer l'objet form
        // depuis le controller
      
        if ($formEquipe->isSubmitted()) {
            $em->persist($equipe);
            $em->flush();
            return $this->redirectToRoute('app_equipe');
        }
        else {
            $vars['formEquipe'] = $formEquipe;
             return $this->render('equipe/affiche_form_insert_equipe.html.twig', $vars);
        }
       

    }


}
