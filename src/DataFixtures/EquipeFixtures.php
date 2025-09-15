<?php

namespace App\DataFixtures;

use App\Entity\Equipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EquipeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $equipeData = ['nom' => 'Gentlemates', 'description' => 'Equipe forte', 'logo' => 'logo.png'];

        foreach ($equipeData as $equipe) {
            $equipe = new Equipe();
            $equipe->setNom($equipe['nom']);
            $equipe->setLogo($equipe['logo']);
            $equipe->setDescription($equipe['description']);
            
            $manager->persist($equipe);
        }

        $manager->flush();
    }
}
