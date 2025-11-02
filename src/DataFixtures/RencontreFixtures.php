<?php

namespace App\DataFixtures;

use App\Entity\Club;
use App\Entity\Equipe;
use App\Entity\Rencontre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTime;

class RencontreFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Créer le club Gentlemates
        $club = new Club();
        $club->setNom('Gentlemates');
        $club->setLogo('gentlemates.png');
        $manager->persist($club);

        // Créer l’équipe Valorant de Gentlemates
        $valorant = new Equipe();
        $valorant->setNom('Gentlemates');
        $valorant->setDescription('Équipe Valorant du club Gentlemates');
        $valorant->setLogo('valorant.png');
        $valorant->setImageFond('valorant.jpg');
        $valorant->setClub($club);
        $manager->persist($valorant);

        // Créer les équipes adverses
        $adversaires = [
            'Vitality' => 'vitality.png',
            'GiantX' => 'giantx.png',
            'BBL' => 'bbl.png',
            'Team Heretics' => 'heretics.png',
            'FUT' => 'fut.png',
        ];

        $equipesAdversaires = [];
        foreach ($adversaires as $nom => $logo) {
            $equipe = new Equipe();
            $equipe->setNom($nom);
            $equipe->setLogo($logo);
            $equipe->setDescription("Équipe adverse Valorant : $nom");
            $manager->persist($equipe);
            $equipesAdversaires[$nom] = $equipe;
        }

        $manager->flush();

        // Créer les rencontres
        $matchs = [
            ['date' => '2025-08-14', 'adversaire' => 'Vitality', 'resultat' => '1 : 2'],
            ['date' => '2025-08-07', 'adversaire' => 'GiantX', 'resultat' => '1 : 2'],
            ['date' => '2025-07-30', 'adversaire' => 'BBL', 'resultat' => '0 : 2'],
            ['date' => '2025-07-24', 'adversaire' => 'Team Heretics', 'resultat' => '1 : 2'],
            ['date' => '2025-07-01', 'adversaire' => 'FUT', 'resultat' => '1 : 2'],
        ];

        foreach ($matchs as $data) {
            $rencontre = new Rencontre();
            $rencontre->setDate(new DateTime($data['date']));
            $rencontre->setJeu('Valorant');
            $rencontre->setResultat('Défaite ' . $data['resultat']);
            $rencontre->addEquipe($valorant);
            $rencontre->addEquipe($equipesAdversaires[$data['adversaire']]);
            $manager->persist($rencontre);
        }

        $manager->flush();
    }
}
