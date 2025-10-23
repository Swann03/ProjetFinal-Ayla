<?php

namespace App\Controller;

use App\Repository\EquipeRepository;
use App\Entity\Equipe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class JoueurController extends AbstractController
{
    // Page principale : liste toutes les équipes
    #[Route('/joueur', name: 'app_joueur')]
    public function index(EquipeRepository $equipeRepository): Response
    {
        $equipes = $equipeRepository->findAll();
        
        return $this->render('joueur/index.html.twig', [
            'equipes' => $equipes,
        ]);
    }
    
    // Page de détail : joueurs d'une équipe
    #[Route('/joueur/equipe/{id}', name: 'app_joueur_equipe')]
    public function equipe(Equipe $equipe): Response
    {
        return $this->render('joueur/equipe.html.twig', [
            'equipe' => $equipe,
        ]);
    }
}
