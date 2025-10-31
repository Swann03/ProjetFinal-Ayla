<?php

namespace App\Controller;

use App\Repository\EquipeRepository;
use App\Entity\Equipe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Joueur;

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

    #[Route('/joueur/init-valorant', name: 'app_joueur_init_valorant')]
public function initValorant(EquipeRepository $equipeRepository, EntityManagerInterface $em): Response
{
    // Récupérer l'équipe Valorant
    $valorant = $equipeRepository->findOneBy(['nom' => 'VALORANT']);
    
    if (!$valorant) {
        return new Response('❌ Équipe VALORANT non trouvée');
    }
    
    // Liste des 5 joueurs
    $joueurs = [
        [
            'nom' => 'Comeback',
            'prenom' => 'Berkcan Senturk',
            'bio' => 'Berkcan "ComeBack" Şentürk is a 17-year-old Turkish Valorant player.
                He joined Gentle Mates in 2025 and quickly established himself as one of the most promising talents on the European scene.
                He brings a fresh and aggressive dynamic to the team as they aim for top performance in the VCT.'
        ],
        [
            'nom' => 'Minny',
            'prenom' => 'Patrik Hušek',
            'bio' => 'Patrik "Minny" Hušek is a Czech Valorant player. Active since 2020, he joined Gentle Mates in December 2024. Despite his young age, he already has an impressive resume that includes great results on the Valorant Challengers East scene.'
        ],
        [
            'nom' => 'Kamyk',
            'prenom' => 'Maks Rychlewski',
            'bio' => 'Maks "Kamyk" Rychlewski is a Polish Valorant player. Active since 2020, he joined Gentle Mates in December 2024. Despite his young age, he    already has an impressive resume that includes great results on the Valorant Challengers East scene.'
        ],
        [
            'nom' => 'Veqaj',
            'prenom' => 'Sylvain Pattyn',
            'bio' => 'Sylvain “Veqaj” Pattyn is a Valorant player.
                He joined Gentle Mates in May 2025 and was awarded MVP at the Spotlight Series EMEA 2024. He was also a finalist of Valorant Challengers Series in 2025.'
        ],
        [
            'nom' => 'Proxh',
            'prenom' => 'Yusuf Emre Tunc',
            'bio' => 'Yusuf “Proxh” Emre Tunc is a German Valorant player.
                He joined Gentle Mates in May 2025, initially on loan from Eintracht Frankfurt before becoming a full-time player for the team !'
        ]
    ];
    
    foreach ($joueurs as $joueurData) {
        $joueur = new Joueur();
        $joueur->setNom($joueurData['nom']);
        $joueur->setPrenom($joueurData['prenom']);
        $joueur->setBio($joueurData['bio']);
        $joueur->setEquipe($valorant);
        
        $em->persist($joueur);
    }
    
    $em->flush();
    
    return new Response('<h1 style="color: green;">✅ 5 joueurs Valorant créés !</h1>
        <ul>
            <li>Proxh (Yusuf Emre Tunc)</li>
            <li>Veqaj (Sylvain Pattyn)</li>
            <li>Kamyk (Maks Rychlewski)</li>
            <li>Minny (Patrik Hušek)</li>
            <li>Comeback (Berkcan Senturk)</li>
        </ul>
        <a href="/joueur" style="padding: 10px 20px; background: purple; color: white; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 20px;">Voir les équipes</a>');
}

}
