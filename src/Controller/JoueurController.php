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

    #[Route('/joueur/init-valorant', name: 'app_joueur_init_valorant')]
    public function initValorant(EquipeRepository $equipeRepository, EntityManagerInterface $em): Response
    {
        // Récupérer l'équipe Valorant
        $valorant = $equipeRepository->findOneBy(['nom' => 'VALORANT']);
        
        if (!$valorant) {
            return new Response('❌ Équipe VALORANT non trouvée. Crée-la d’abord via /equipe/initialiser.');
        }
        
        // Liste des joueurs Valorant
        $joueurs = [
            [
                'nom' => 'Berkcan Şentürk',
                'pseudo' => 'Comeback',
                'bio' => 'Berkcan "ComeBack" Şentürk is a 17-year-old Turkish Valorant player. He joined Gentle Mates in 2025 and quickly established himself as one of the most promising talents on the European scene.'
            ],
            [
                'nom' => 'Patrik Hušek',
                'pseudo' => 'Minny',
                'bio' => 'Patrik "Minny" Hušek is a Czech Valorant player. Active since 2020, he joined Gentle Mates in December 2024. Despite his young age, he already has an impressive resume.'
            ],
            [
                'nom' => 'Maks Rychlewski',
                'pseudo' => 'Kamyk',
                'bio' => 'Maks "Kamyk" Rychlewski is a Polish Valorant player. Active since 2020, he joined Gentle Mates in December 2024 with great results on the Valorant Challengers East scene.'
            ],
            [
                'nom' => 'Sylvain Pattyn',
                'pseudo' => 'Veqaj',
                'bio' => 'Sylvain "Veqaj" Pattyn joined Gentle Mates in May 2025. He was awarded MVP at the Spotlight Series EMEA 2024 and was a finalist of Valorant Challengers Series in 2025.'
            ],
            [
                'nom' => 'Emre Tunc',
                'pseudo' => 'Proxh',
                'bio' => 'Yusuf "Proxh" Emre Tunc is a German Valorant player. He joined Gentle Mates in May 2025, initially on loan from Eintracht Frankfurt before becoming a full-time player!'
            ]
        ];

        foreach ($joueurs as $data) {
            $exist = $em->getRepository(Joueur::class)->findOneBy([
                'nom' => $data['nom'],
                'pseudo' => $data['pseudo'],
                'equipe' => $valorant
            ]);

            if (!$exist) {
                $joueur = new Joueur();
                $joueur->setNom($data['nom']);
                $joueur->setPseudo($data['pseudo']);
                $joueur->setBio($data['bio']);
                $joueur->setEquipe($valorant);
                $em->persist($joueur);
            }
        }

        $em->flush();

        return new Response('<h1 style="color: green;">✅ 5 joueurs Valorant créés !</h1>
            <ul>
                <li>Comeback (Şentürk)</li>
                <li>Minny (Hušek)</li>
                <li>Kamyk (Rychlewski)</li>
                <li>Veqaj (Pattyn)</li>
                <li>Proxh (Tunc)</li>
            </ul>
            <a href="/joueur/liste" style="padding: 10px 20px; background: purple; color: white; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 20px;">Voir les joueurs</a>');
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
