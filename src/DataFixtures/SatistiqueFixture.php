<?php

namespace App\DataFixtures;

use App\Entity\Statistique;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class StatistiquesFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 20; $i++) { 
            $stat = new Statistique();

            $stat->setKillCount($faker->numberBetween(0, 20));   
            $stat->setDeadCount($faker->numberBetween(0, 20));   
            $stat->setAssistCount($faker->numberBetween(0, 20)); 

            $manager->persist($stat);
        }

        $manager->flush();
    }
}
