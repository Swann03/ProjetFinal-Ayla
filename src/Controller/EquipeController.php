<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\EquipeType;

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

}
