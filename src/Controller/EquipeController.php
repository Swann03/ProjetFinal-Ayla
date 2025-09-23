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
    $formEquipe = $this->createForm(EquipeType::class);
    return $this->render('equipe/index.html.twig', [
        'formEquipe' => $formEquipe->createView()
    ]);
}

#[Route('/equipe/insert', name: 'app_equipe_insert')]
public function InsertForm(Request $req, EntityManagerInterface $em): Response
{
    $equipe = new Equipe();
    $formEquipe = $this->createForm(EquipeType::class, $equipe);
    $formEquipe->handleRequest($req);
      
    if ($formEquipe->isSubmitted() && $formEquipe->isValid()) {
        $em->persist($equipe);
        $em->flush();
        return $this->redirectToRoute('app_equipe');
    }

    return $this->render('equipe/affiche_form_insert_equipe.html.twig', [
        'formEquipe' => $formEquipe->createView()
    ]);
}
    


}
