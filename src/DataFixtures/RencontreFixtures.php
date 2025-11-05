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
        // 1️⃣ On récupère l’équipe GENTLEMATES (le club principal)
        $gentlemates = $manager->getRepository(Equipe::class)->findOneBy(['isClubPrincipal' => true]);

        if (!$gentlemates) {
            // Sécurité : on la crée si elle n’existe pas encore
            $gentlemates = new Equipe();
            $gentlemates->setNom('Gentlemates');
            $gentlemates->setLogo('gentlemates.png');
            $gentlemates->setImageFond('gentlemates-banner.jpg');
            $gentlemates->setDescription('Club eSport officiel Gentlemates.');
            $gentlemates->setIsAdversaire(false);
            $gentlemates->setIsClubPrincipal(true);
            $manager->persist($gentlemates);
        }

        // 2️⃣ On récupère les adversaires
        $adversaires = [
            'Vitality'       => 'vitality.png',
            'GiantX'         => 'giantx.png',
            'BBL'            => 'bbl.png',
            'Team Heretics'  => 'heretics.png',
            'FUT'            => 'fut.png',
        ];

        $equipesAdverses = [];
        foreach ($adversaires as $nom => $logo) {
            $equipe = $manager->getRepository(Equipe::class)->findOneBy(['nom' => $nom]);
            if (!$equipe) {
                $equipe = new Equipe();
                $equipe->setNom($nom);
                $equipe->setLogo($logo);
                $equipe->setDescription("Équipe adverse : $nom");
                $equipe->setIsAdversaire(true);
                $equipe->setIsClubPrincipal(false);
                $manager->persist($equipe);
            }
            $equipesAdverses[$nom] = $equipe;
        }

        $manager->flush();

        // 3️⃣ Création des matchs
        $matchs = [
           ['date' => '2025-08-14', 'adversaire' => 'Vitality',      'resultat' => '1 : 2'],
            ['date' => '2025-08-07', 'adversaire' => 'GiantX',        'resultat' => '1 : 2'],
            ['date' => '2025-07-30', 'adversaire' => 'BBL',           'resultat' => '0 : 2'],
            ['date' => '2025-07-24', 'adversaire' => 'Team Heretics', 'resultat' => '1 : 2'],
            ['date' => '2025-07-01', 'adversaire' => 'FUT',           'resultat' => '1 : 2']
        ];

        foreach ($matchs as $data) {
            $rencontre = new Rencontre();
            $rencontre->setDate(new DateTime($data['date']));
            $rencontre->setJeu('Valorant');
            $rencontre->setResultat($data['resultat']);

            // ✅ On associe Gentlemates (club principal) et l’adversaire
            $rencontre->addEquipe($gentlemates);
            $rencontre->addEquipe($equipesAdverses[$data['adversaire']]);

            $manager->persist($rencontre);
        }

        $adversairesCs2 = [
            'GamerLegion'     => 'gamelegion.png',
            'BetBoom'         => 'betboom.png',
            'Ninja in Pyjamas' => 'nip.png',
            'Legacy'          => 'legacy.png',
            'pain'            => 'pain.png',
        ];

        $equipesAdversesCs2 = [];
        foreach ($adversairesCs2 as $nom => $logo) {
            $equipe = $manager->getRepository(Equipe::class)->findOneBy(['nom' => $nom]);
            if (!$equipe) {
                $equipe = new Equipe();
                $equipe->setNom($nom);
                $equipe->setLogo($logo);
                $equipe->setDescription("Équipe adverse : $nom");
                $equipe->setIsAdversaire(true);
                $equipe->setIsClubPrincipal(false);
                $manager->persist($equipe);
            }
            $equipesAdversesCs2[$nom] = $equipe;
        }

        $matchsCS2 = [
            ['date' => '2025-10-30', 'adversaire' => 'GamerLegion',      'resultat' => '0 : 2'],
            ['date' => '2025-10-29', 'adversaire' => 'BetBoom',        'resultat' => '2 : 1'],
            ['date' => '2025-10-28', 'adversaire' => 'Ninja in Pyjamas',           'resultat' => '2 : 1'],
            ['date' => '2025-10-27', 'adversaire' => 'Legacy', 'resultat' => '0 : 2'],
            ['date' => '2025-10-26', 'adversaire' => 'pain',           'resultat' => '0 : 2']
        ];

        foreach ($matchsCS2 as $data) {
            $rencontre = new Rencontre();
            $rencontre->setDate(new DateTime($data['date']));
            $rencontre->setJeu('CS2');
            $rencontre->setResultat($data['resultat']);

            // ✅ On associe Gentlemates (club principal) et l’adversaire
            $rencontre->addEquipe($gentlemates);
            $rencontre->addEquipe($equipesAdversesCs2[$data['adversaire']]);

            $manager->persist($rencontre);
        }

        $manager->flush();
    }

}


 