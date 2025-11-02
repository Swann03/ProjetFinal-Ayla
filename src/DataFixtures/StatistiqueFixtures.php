<?php

namespace App\DataFixtures;

use App\Entity\Statistique;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Rencontre;


class StatistiqueFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $rencontres = $manager->getRepository(Rencontre::class)->findAll();

        for ($i = 0; $i < 5; $i++) { 
            $stat = new Statistique();

            $stat->setKillCount($faker->numberBetween(0, 5));   
            $stat->setDeadCount($faker->numberBetween(0, 5));   
            $stat->setAssistCount($faker->numberBetween(0, 5)); 
            $stat->setRencontre($rencontres[$i]);

            $manager->persist($stat);
        }

        $manager->flush();
    }
}