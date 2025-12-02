<?php

namespace App\DataFixtures;

use App\Entity\Vote;
use App\Entity\Rencontre;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VoteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $rencontreRepo = $manager->getRepository(Rencontre::class);
        $userRepo = $manager->getRepository(Utilisateur::class);

        $rencontres = $rencontreRepo->findAll();
        $utilisateurs = $userRepo->findAll();

        if (empty($rencontres) || empty($utilisateurs)) {
            return; 
        }

        foreach ($rencontres as $rencontre) {
            $gentlemates = $rencontre->getEquipeGentlemates();
            $adversaire = $rencontre->getEquipeAdversaire();

            if (!$gentlemates || !$adversaire) {
                continue;
            }

          
            foreach (array_slice($utilisateurs, 0, 3) as $index => $user) {
                $vote = new Vote();
                $vote->setUtilisateur($user);
                $vote->setRencontre($rencontre);

             
                if ($index % 2 === 0) {
                    $vote->setEquipe($gentlemates);
                    $vote->setChoix('GENTLEMATES');
                } else {
                    $vote->setEquipe($adversaire);
                    $vote->setChoix('ADVERSAIRE');
                }

                $manager->persist($vote);
            }
        }

        $manager->flush();
    }
}

