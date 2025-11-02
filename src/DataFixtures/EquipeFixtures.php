<?php

namespace App\DataFixtures;

use App\Entity\Equipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EquipeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $jeux = [
            ['VALORANT', 'valorant.png', 'valorant.jpg'],
            ['COUNTER STRIKE', 'cs.png', 'cs.jpg'],
            ['FORTNITE', 'fortnite.png', 'fortnite.jpg'],
            ['TEAMFIGHT TACTICS', 'tft.png', 'tft.jpg'],
            ['AGE OF EMPIRES', 'aoe.png', 'aoe.jpg'],
            ['ROCKET LEAGUE', 'rocket.png', 'rocket-league.jpg'],
            ['CALL OF DUTY', 'cod.png', 'cod.jpg'],
            ['CALL OF DUTY WARZONE', 'cod-warzone.png', 'cod-warzone.jpg'],
        ];

        foreach ($jeux as $jeu) {
            $equipe = new Equipe();
            $equipe->setNom($jeu[0]);
            $equipe->setLogo($jeu[1]);
            $equipe->setImageFond($jeu[2]);
            $manager->persist($equipe);
        }

        $manager->flush();
    }
}
