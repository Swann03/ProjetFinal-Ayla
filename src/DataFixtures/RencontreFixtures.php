<?php

namespace App\DataFixtures;

use App\Entity\Equipe;
use App\Entity\Rencontre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTime;

class RencontreFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // 1) GENTLEMATES (not adversaire)
        $gentlemates = $manager->getRepository(Equipe::class)->findOneBy(['nom' => 'Gentlemates']);
        if (!$gentlemates) {
            $gentlemates = new Equipe();
            $gentlemates->setNom('Gentlemates');
        }
        $gentlemates->setDescription('Équipe Valorant de Gentlemates');
        $gentlemates->setLogo('gentlemates.png');
        $gentlemates->setImageFond('valorant.jpg');
        $gentlemates->setIsAdversaire(false); // ✅ IMPORTANT
        $manager->persist($gentlemates);

        // 2) ADVERSAIRES (must be isAdversaire = true)
        $adversaires = [
            'Vitality'       => 'vitality.png',
            'GiantX'         => 'giantx.png',
            'BBL'            => 'bbl.png',
            'Team Heretics'  => 'heretics.png',
            'FUT'            => 'fut.png',
        ];

        $equipesAdversaires = [];
        foreach ($adversaires as $nom => $logo) {
            // upsert par nom (évite les doublons et met à jour si déjà créé ailleurs)
            $equipe = $manager->getRepository(Equipe::class)->findOneBy(['nom' => $nom]);
            if (!$equipe) {
                $equipe = new Equipe();
                $equipe->setNom($nom);
            }
            $equipe->setLogo($logo);
            $equipe->setDescription("Équipe adverse Valorant : $nom");
            $equipe->setIsAdversaire(true); // ✅ FORCE le flag
            $manager->persist($equipe);

            $equipesAdversaires[$nom] = $equipe;
        }

        $manager->flush();

        // 3) MATCHS (exemple)
        $matchs = [
            ['date' => '2025-08-14', 'adversaire' => 'Vitality',      'resultat' => '1 : 2'],
            ['date' => '2025-08-07', 'adversaire' => 'GiantX',        'resultat' => '1 : 2'],
            ['date' => '2025-07-30', 'adversaire' => 'BBL',           'resultat' => '0 : 2'],
            ['date' => '2025-07-24', 'adversaire' => 'Team Heretics', 'resultat' => '1 : 2'],
            ['date' => '2025-07-01', 'adversaire' => 'FUT',           'resultat' => '1 : 2'],
        ];

        foreach ($matchs as $data) {
            $rencontre = new Rencontre();
            $rencontre->setDate(new DateTime($data['date']));
            $rencontre->setJeu('Valorant');
            $rencontre->setResultat($data['resultat']);
            // relation ManyToMany (selon ton modèle)
            $rencontre->addEquipe($gentlemates);
            $rencontre->addEquipe($equipesAdversaires[$data['adversaire']]);
            $manager->persist($rencontre);
        }

        $manager->flush();
    }
}
