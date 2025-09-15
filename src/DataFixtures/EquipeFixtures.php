<?php

namespace App\DataFixtures;

use App\Entity\Equipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EquipeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $equipes = [
            [
                'nom' => 'Paris Saint-Germain',
                'logo' => 'psg-logo.png',
                'description' => 'Paris Saint-Germain Football Club, commonly referred to as Paris Saint-Germain, Paris SG or PSG, is a French professional football club based in Paris.'
            ],
            [
                'nom' => 'Olympique de Marseille',
                'logo' => 'om-logo.png',
                'description' => 'Olympique de Marseille is a French professional football club in Marseille. Founded in 1899, the club plays in Ligue 1 and have spent most of their history in the top tier of French football.'
            ],
            [
                'nom' => 'Olympique Lyonnais',
                'logo' => 'ol-logo.png',
                'description' => 'Olympique Lyonnais is a French professional football club based in Lyon. The club plays in Ligue 1 and has won seven consecutive Ligue 1 titles from 2002 to 2008.'
            ],
            [
                'nom' => 'AS Monaco',
                'logo' => 'monaco-logo.png',
                'description' => 'Association Sportive de Monaco Football Club, commonly referred to as AS Monaco or simply Monaco, is a Monégasque professional football club based in Fontvieille.'
            ],
            [
                'nom' => 'Lille OSC',
                'logo' => 'lille-logo.png',
                'description' => 'Lille Olympique Sporting Club, commonly referred to as LOSC, LOSC Lille or simply Lille, is a French professional football club based in Lille.'
            ]
        ];

        foreach ($equipes as $equipeData) {
            $equipe = new Equipe();
            $equipe->setNom($equipeData['nom']);
            $equipe->setLogo($equipeData['logo']);
            $equipe->setDescription($equipeData['description']);
            
            $manager->persist($equipe);
        }

        $manager->flush();
    }
}
