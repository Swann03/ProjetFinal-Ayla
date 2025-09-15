<?php

namespace App\DataFixtures;

use App\Entity\Equipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EquipeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $gentlemates = new Equipe();
        $gentlemates->setNom('Gentlemates');
        $gentlemates->setDescription('Equipe forte');
        $gentlemates->setLogo('logo.png');
        $manager->persist($gentlemates);

        $manager->flush();
    }
}
