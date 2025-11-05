<?php

namespace App\DataFixtures;

use App\Entity\Equipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EquipeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // 1️⃣ CLUB PRINCIPAL
        $gentlemates = new Equipe();
        $gentlemates->setNom('Gentlemates');
        $gentlemates->setLogo('gentlemates.png');
        $gentlemates->setImageFond('gentlemates-banner.jpg');
        $gentlemates->setDescription('Club eSport officiel créé par Squeezie, Gotaga et Brawks.');
        $gentlemates->setIsAdversaire(true);
        $gentlemates->setIsClubPrincipal(true); // ✅ Nouveau champ
        $manager->persist($gentlemates);

        // 2️⃣ ÉQUIPES DE JEUX DU CLUB
        $jeux = [
            ['VALORANT', 'valorant.png', 'valorant.jpg'],
            ['COUNTER STRIKE 2', 'cs.png', 'cs.jpg'],
            ['FORTNITE', 'fortnite.png', 'fortnite.jpg'],
            ['TEAMFIGHT TACTICS', 'tft.png', 'tft.jpg'],
            ['AGE OF EMPIRES', 'aoe.png', 'aoe.jpg'],
            ['ROCKET LEAGUE', 'rocket.png', 'rocket-league.jpg'],
            ['CALL OF DUTY', 'cod.png', 'cod.jpg'],
            ['CALL OF DUTY WARZONE', 'cod-warzone.png', 'cod-warzone.jpg'],
        ];

        foreach ($jeux as [$nom, $logo, $fond]) {
            $equipe = new Equipe();
            $equipe->setNom($nom);
            $equipe->setLogo($logo);
            $equipe->setImageFond($fond);
            $equipe->setDescription("Équipe officielle Gentlemates sur le jeu $nom.");
            $equipe->setIsAdversaire(false);
            $equipe->setIsClubPrincipal(false);
            $manager->persist($equipe);
        }           

        // 3️⃣ ÉQUIPES ADVERSAIRES
        $adversaires = [
            ['Vitality', 'vitality.png'],
            ['GiantX', 'giantx.png'],
            ['BBL', 'bbl.png'],
            ['Team Heretics', 'heretics.png'],
            ['FUT', 'fut.png'],
            
        ];

        foreach ($adversaires as [$nom, $logo]) {
            $equipe = new Equipe();
            $equipe->setNom($nom);
            $equipe->setLogo($logo);
            $equipe->setImageFond($logo);
            $equipe->setDescription("Équipe adverse concurrente : $nom");
            $equipe->setIsAdversaire(true);
            $equipe->setIsClubPrincipal(false);
            $manager->persist($equipe);
        }

        $manager->flush();
    }
}
