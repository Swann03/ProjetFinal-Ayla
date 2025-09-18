<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Rencontre;
use Faker\Factory;

class RencontreFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR'); // Faker en français

        for ($i = 0; $i < 20; $i++) {
            $rencontre = new Rencontre();
            $rencontre->setJeu($faker->randomElement(['Age of Empires', 'CS2', 'LoL', 'Rocket League', 'Fortnite', 'TeamFight Tactics', 'Valorant', 'Call of Duty', 'Warzone']));
            $rencontre->setResultat($faker->randomElement(['gagner', 'perdre', 'egalite']));
            $rencontre->setDate($faker->dateTimeBetween('now', '+30 days'));
            $manager->persist($rencontre);
        }

        $manager->flush();
    }
}

