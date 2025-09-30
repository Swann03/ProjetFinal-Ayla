<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Joueur;
use App\Entity\Equipe;

class JoueurFixtures extends Fixture
{
    public function load(ObjectManager $manager):void
    {
        for ($i = 0; $i < 20; $i++) {
            $joueur = new Joueur();
            $joueur->setNom("Joueur $i");
            $joueur->setBio("Ceci est la bio du joueur numéro $i.");
            $joueur->setEquipe($this->getReference('equipe'. rand(1,4), Equipe::class));
            $manager->persist($joueur);
        }

        $manager->flush();
    }
}
