<?php

namespace App\DataFixtures;

use App\Entity\Equipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EquipeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for ($i = 1; $i <= 4; $i++) {
            $gentlemates = new Equipe();
            $gentlemates->setNom('Gentlemates'.$i);
            $gentlemates->setDescription('Equipe forte'.$i);
            $gentlemates->setLogo('logo'.$i . '.png');
            $this->addReference('equipe'.$i, $gentlemates); 
            $manager->persist($gentlemates);
        }
        $manager->flush();
    }
}
