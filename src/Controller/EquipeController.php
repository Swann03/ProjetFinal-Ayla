<?php

namespace App\Controller;

use App\Entity\Equipe;
use App\Entity\Club;
use App\Repository\EquipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EquipeController extends AbstractController
{
    #[Route('/equipe', name: 'app_equipe')]
    public function index(EquipeRepository $repo): Response
    {
        $equipes = $repo->findAll();
        return $this->render('equipe/index.html.twig', [
            'equipes' => $equipes
        ]);
    }

    #[Route('/equipe/initialiser', name: 'app_equipe_initialiser')]
    public function initialiser(EntityManagerInterface $em, EquipeRepository $repo): Response
    {
        // Vérifie si le club existe, sinon le crée
        $club = $em->getRepository(Club::class)->findOneBy(['nom' => 'Gentlemates']);
        if (!$club) {
            $club = new Club();
            $club->setNom('Gentlemates');
            $club->setLogo('gentlemates.png');
            $em->persist($club);
        }

        $jeux = [
            ['nom' => 'Valorant', 'logo' => 'valorant.png', 'imageFond' => 'valorant.jpg'],
            ['nom' => 'Fortnite', 'logo' => 'fortnite.png', 'imageFond' => 'fortnite.jpg'],
            ['nom' => 'Rocket League', 'logo' => 'rocket-league.png', 'imageFond' => 'rocket-league.jpg'],
            ['nom' => 'Teamfight Tactics', 'logo' => 'tft.png', 'imageFond' => 'tft.jpg'],
        ];

        foreach ($jeux as $jeu) {
            $exist = $repo->findOneBy(['nom' => $jeu['nom']]);
            if (!$exist) {
                $equipe = new Equipe();
                $equipe->setNom($jeu['nom']);
                $equipe->setLogo($jeu['logo']);
                $equipe->setImageFond($jeu['imageFond']);
                $equipe->setClub($club);
                $equipe->setDescription('Équipe Gentlemates ' . $jeu['nom']);
                $em->persist($equipe);
            }
        }

        $em->flush();

        return new Response('<h2 style="color:green;">✅ Équipes du club Gentlemates créées !</h2>
            <a href="/equipe" style="padding:10px 20px;background:purple;color:white;text-decoration:none;border-radius:5px;">Voir les équipes</a>');
    }
}
