<?php

namespace App\DataFixtures;

use App\Entity\Joueur;
use App\Entity\Equipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class JoueurFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // On récupère l’équipe Valorant
        $valorant = $manager->getRepository(Equipe::class)->findOneBy(['nom' => 'Valorant']);

        if (!$valorant) {
            throw new \Exception('⚠️ L’équipe Valorant doit exister avant d’ajouter les joueurs. Lance d’abord EquipeFixtures.');
        }

        // Liste des joueurs
        $joueurs = [
            [
                'nom' => 'Berkcan Şentürk',
                'pseudo' => 'Comeback',
                'bio' => 'Berkcan "ComeBack" Şentürk est un joueur turc de 17 ans. Il a rejoint Gentle Mates en 2025 et s’est imposé comme un talent prometteur sur la scène européenne.'
            ],
            [
                'nom' => 'Patrik Hušek',
                'pseudo' => 'Minny',
                'bio' => 'Patrik "Minny" Hušek est un joueur tchèque. Actif depuis 2020, il a rejoint Gentle Mates fin 2024 avec un parcours impressionnant.'
            ],
            [
                'nom' => 'Maks Rychlewski',
                'pseudo' => 'Kamyk',
                'bio' => 'Maks "Kamyk" Rychlewski est un joueur polonais, actif depuis 2020. Il a rejoint Gentle Mates en 2024 après une belle performance sur la scène Valorant East.'
            ],
            [
                'nom' => 'Sylvain Pattyn',
                'pseudo' => 'Veqaj',
                'bio' => 'Sylvain "Veqaj" Pattyn a rejoint Gentle Mates en 2025. MVP à la Spotlight Series EMEA 2024, il est une pièce maîtresse de l’équipe.'
            ],
            [
                'nom' => 'Emre Tunc',
                'pseudo' => 'Proxh',
                'bio' => 'Yusuf "Proxh" Emre Tunc, joueur allemand, a d’abord rejoint Gentle Mates en prêt depuis Eintracht Frankfurt avant d’être signé définitivement.'
            ],
        ];

        foreach ($joueurs as $data) {
            $joueur = new Joueur();
            $joueur->setNom($data['nom']);
            $joueur->setPseudo($data['pseudo']);
            $joueur->setBio($data['bio']);
            $joueur->setEquipe($valorant);

            $manager->persist($joueur);
        }

        $manager->flush();
    }
}
