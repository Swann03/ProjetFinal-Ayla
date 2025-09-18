<?php

namespace App\DataFixtures;

use App\Entity\Media;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class MediaFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR'); 

        $jeux = ['Age of Empires', 'CS2', 'LoL', 'Rocket League', 'Fortnite', 'TeamFight Tactics', 'Valorant', 'Call of Duty', 'Warzone'];

        for ($i = 0; $i < 15; $i++) { 
            $media = new Media();

            $media->setTitre($faker->sentence(10)); 
            
 
            $media->setJeu($faker->randomElement($jeux)); 

            $manager->persist($media);
        }

        $manager->flush();
    }
}
