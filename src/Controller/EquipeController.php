<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Entity\Club;
use App\Repository\EquipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class EquipeController extends AbstractController
{
    #[Route('/equipe', name: 'app_equipe')]
    public function index(EquipeRepository $equipeRepository): Response
    {
        // ✅ On récupère uniquement les équipes NON adversaires
        $equipes = $equipeRepository->findBy(['isAdversaire' => false]);

        return $this->render('equipe/index.html.twig', [
            'equipes' => $equipes,
        ]);
    }

    #[Route('/equipe/initialiser', name: 'app_equipe_initialiser')]
    public function initialiser(EntityManagerInterface $em, EquipeRepository $equipeRepository): Response
    {
        // ✅ Crée le club Gentlemates s’il n’existe pas
        $club = $em->getRepository(Club::class)->findOneBy(['nom' => 'Gentlemates']);
        if (!$club) {
            $club = new Club();
            $club->setNom('Gentlemates');
            $club->setLogo('gentlemates.png');
            $em->persist($club);
        }

        // ✅ Liste des équipes du club
        $jeux = [
            ['nom' => 'Valorant', 'logo' => 'valorant.png', 'imageFond' => 'valorant.jpg'],
            ['nom' => 'Fortnite', 'logo' => 'fortnite.png', 'imageFond' => 'fortnite.jpg'],
            ['nom' => 'Rocket League', 'logo' => 'rocket-league.png', 'imageFond' => 'rocket-league.jpg'],
            ['nom' => 'Teamfight Tactics', 'logo' => 'tft.png', 'imageFond' => 'tft.jpg'],
        ];

        foreach ($jeux as $jeu) {
            $equipe = $equipeRepository->findOneBy(['nom' => $jeu['nom']]);

            if (!$equipe) {
                $equipe = new Equipe();
                $equipe->setNom($jeu['nom']);
            }

            $equipe->setLogo($jeu['logo']);
            $equipe->setImageFond($jeu['imageFond']);
            $equipe->setClub($club);
            $equipe->setDescription('Équipe Gentlemates ' . $jeu['nom']);
            $equipe->setIsAdversaire(false); // ✅ clé du problème
            $em->persist($equipe);
        }

        $em->flush();

        return new Response('<h2 style="color:green;">✅ Équipes du club Gentlemates créées ou mises à jour !</h2>
            <a href="/equipe" style="padding:10px 20px;background:purple;color:white;text-decoration:none;border-radius:5px;">Voir les équipes</a>');
    }
}
