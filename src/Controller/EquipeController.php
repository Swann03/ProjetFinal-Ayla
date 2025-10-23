<?php

namespace App\Controller;

use App\Repository\EquipeRepository;
use App\Entity\Equipe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EquipeController extends AbstractController
{
    // Page principale : liste toutes les équipes
    #[Route('/equipe', name: 'app_equipe')]
    public function index(EquipeRepository $equipeRepository): Response
    {
        $equipes = $equipeRepository->findAll();
        
        return $this->render('equipe/index.html.twig', [
            'equipes' => $equipes,
        ]);
    }
    
    // Page de détail d'une équipe
    #[Route('/equipe/{id}', name: 'app_equipe_show')]
    public function show(Equipe $equipe): Response
    {
        return $this->render('equipe/show.html.twig', [
            'equipe' => $equipe,
        ]);
    }
}

