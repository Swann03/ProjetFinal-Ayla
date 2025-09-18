<?php

namespace App\DataFixtures;

use App\Entity\Vote;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class VoteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 30; $i++) { 
            $vote = new Vote();

            $vote->setPoint($faker->numberBetween(0, 10)); 

            $manager->persist($vote);
        }

        $manager->flush();
    }
}
