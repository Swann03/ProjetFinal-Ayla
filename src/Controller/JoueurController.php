<?php

namespace App\Controller;

use App\Entity\Joueur;
use App\Repository\EquipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class JoueurController extends AbstractController
{
    #[Route('/joueur', name: 'app_joueur')]
    public function index(EquipeRepository $equipeRepository): Response
    {
        $equipes = $equipeRepository->findBy(['isAdversaire' => false]);
        return $this->render('joueur/index.html.twig', [
            'equipes' => $equipes
        ]);
    }

    
    #[Route('/joueur/liste', name: 'app_joueur_liste')]
    public function liste(EntityManagerInterface $em): Response
    {
        $joueurs = $em->getRepository(Joueur::class)->findAll();
        
        return $this->render('joueur/liste.html.twig', [
            'joueurs' => $joueurs
        ]);
    }

   #[Route('/joueur/equipe/{id}', name: 'app_equipe_detail')]
public function joueursParEquipe($id, EquipeRepository $equipeRepository): Response
{
    // On force $id à être un entier avant la recherche
    $equipe = $equipeRepository->find((int) $id);

    if (!$equipe) {
        throw $this->createNotFoundException("Équipe non trouvée pour l’ID $id");
    }

    return $this->render('joueur/equipe.html.twig', [
        'equipe' => $equipe
    ]);
}


}
