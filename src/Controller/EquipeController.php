<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\EquipeType;
use App\Repository\EquipeRepository;
use Doctrine\ORM\EntityManagerInterface;

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

    #[Route('/equipe/ajouter-images', name: 'app_equipe_images')]
public function ajouterImages(EquipeRepository $equipeRepository, EntityManagerInterface $em): Response
{
    // Association nom d'équipe => nom de fichier
    $images = [
        'VALORANT' => 'valorant.jpg',
        'COUNTER STRIKE' => 'cs.jpg',
        'FORTNITE' => 'fortnite.jpg',
        'TEAMFIGHT TACTICS' => 'tft.jpg',
        'AGE OF EMPIRES' => 'aoe.jpg',
        'ROCKET LEAGUE' => 'rocket-league.jpg',
        'CALL OF DUTY' => 'cod.jpg',
        'CALL OF DUTY WARZONE' => 'cod-warzone.jpg',
    ];
    
    $equipes = $equipeRepository->findAll();
    
    foreach ($equipes as $equipe) {
        $nomEquipe = $equipe->getNom();
        if (isset($images[$nomEquipe])) {
            $equipe->setImageFond($images[$nomEquipe]);
        }
    }
    
    $em->flush();
    
    return new Response('<h1 style="color: green;">✅ Images de fond ajoutées !</h1>
        <a href="/joueur" style="padding: 10px 20px; background: purple; color: white; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 20px;">Voir les cartes</a>');
}


    
}

