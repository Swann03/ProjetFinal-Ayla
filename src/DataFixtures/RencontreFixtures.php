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
        // 1️⃣ Récupération ou création de l’équipe GENTLEMATES (club principal)
        $gentlemates = $manager->getRepository(Equipe::class)->findOneBy(['isClubPrincipal' => true]);

        if (!$gentlemates) {
            $gentlemates = new Equipe();
            $gentlemates->setNom('Gentlemates');
            $gentlemates->setLogo('gentlemates.png');
            $gentlemates->setImageFond('gentlemates-banner.jpg');
            $gentlemates->setDescription('Club eSport officiel Gentlemates.');
            $gentlemates->setIsAdversaire(false);
            $gentlemates->setIsClubPrincipal(true);
            $manager->persist($gentlemates);
        }

        // 2️⃣ Adversaires VALORANT
        $adversairesValorant = [
            'Vitality'       => 'vitality.png',
            'GiantX'         => 'giantx.png',
            'BBL'            => 'bbl.png',
            'Team Heretics'  => 'heretics.png',
            'FUT'            => 'fut.png',
        ];

        $equipesAdversesValorant = [];
        foreach ($adversairesValorant as $nom => $logo) {
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
            $equipesAdversesValorant[$nom] = $equipe;
        }

        // 3️⃣ Adversaires CS2
        $adversairesCs2 = [
            'GamerLegion'       => 'gamelegion.png',
            'BetBoom'           => 'betboom.png',
            'Ninja in Pyjamas'  => 'nip.png',
            'Legacy'            => 'legacy.png',
            'pain'              => 'pain.png',
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

        // 4️⃣ Adversaires ROCKET LEAGUE
        $adversairesRL = [
            'Magnifico'      => 'magnifico.png',
            'Geekay'         => 'geekay.png',
            'Cloud Esport'   => 'cloud.png',
            'Karmine Corp'   => 'kc.png',
            'Chippie Chips'  => 'chippie.png',
        ];

        $equipesAdversesRL = [];
        foreach ($adversairesRL as $nom => $logo) {
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
            $equipesAdversesRL[$nom] = $equipe;
        }

        // 5️⃣ Adversaires COD
        $adversairesCOD = [
            'Optic Gaming'        => 'Optic.png',
            'Los Angeles Thieves' => 'lat.png',
        ];

        $equipesAdversesCOD = [];
        foreach ($adversairesCOD as $nom => $logo) {
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
            // ✅ ICI : on remplit bien le bon tableau
            $equipesAdversesCOD[$nom] = $equipe;
        }

        // 💾 On sauvegarde toutes les équipes créées avant les matchs
        $manager->flush();

        // 6️⃣ Matchs VALORANT
        $matchsValorant = [
            ['date' => '2025-08-14', 'adversaire' => 'Vitality',      'resultat' => '1 : 2'],
            ['date' => '2025-08-07', 'adversaire' => 'GiantX',        'resultat' => '1 : 2'],
            ['date' => '2025-07-30', 'adversaire' => 'BBL',           'resultat' => '0 : 2'],
            ['date' => '2025-07-24', 'adversaire' => 'Team Heretics', 'resultat' => '1 : 2'],
            ['date' => '2025-07-01', 'adversaire' => 'FUT',           'resultat' => '1 : 2'],
        ];

        foreach ($matchsValorant as $data) {
            $rencontre = new Rencontre();
            $rencontre->setDate(new DateTime($data['date']));
            $rencontre->setJeu('valorant');
            $rencontre->setResultat($data['resultat']);

            $rencontre->addEquipe($gentlemates);
            $rencontre->addEquipe($equipesAdversesValorant[$data['adversaire']]);

            $manager->persist($rencontre);
        }

        // 7️⃣ Matchs CS2
        $matchsCS2 = [
            ['date' => '2025-10-30', 'adversaire' => 'GamerLegion',      'resultat' => '0 : 2'],
            ['date' => '2025-10-29', 'adversaire' => 'BetBoom',          'resultat' => '2 : 1'],
            ['date' => '2025-10-28', 'adversaire' => 'Ninja in Pyjamas', 'resultat' => '2 : 1'],
            ['date' => '2025-10-27', 'adversaire' => 'Legacy',           'resultat' => '0 : 2'],
            ['date' => '2025-10-26', 'adversaire' => 'pain',             'resultat' => '0 : 2'],
        ];

        foreach ($matchsCS2 as $data) {
            $rencontre = new Rencontre();
            $rencontre->setDate(new DateTime($data['date']));
            $rencontre->setJeu('cs2');
            $rencontre->setResultat($data['resultat']);

            $rencontre->addEquipe($gentlemates);
            $rencontre->addEquipe($equipesAdversesCs2[$data['adversaire']]);

            $manager->persist($rencontre);
        }

        // 8️⃣ Matchs ROCKET LEAGUE
        $matchsRL = [
            ['date' => '2025-11-23', 'adversaire' => 'Magnifico',     'resultat' => '4 : 3'],
            ['date' => '2025-11-21', 'adversaire' => 'Geekay',        'resultat' => '3 : 1'],
            ['date' => '2025-11-21', 'adversaire' => 'Cloud Esport',  'resultat' => '3 : 0'],
            ['date' => '2025-11-21', 'adversaire' => 'Karmine Corp',  'resultat' => '1 : 3'],
            ['date' => '2025-11-16', 'adversaire' => 'Chippie Chips', 'resultat' => '3 : 0'],
        ];

        foreach ($matchsRL as $data) {
            $rencontre = new Rencontre();
            $rencontre->setDate(new DateTime($data['date']));
            $rencontre->setJeu('Rocket League'); // ou 'rl' si ton front attend ça
            $rencontre->setResultat($data['resultat']);

            $rencontre->addEquipe($gentlemates);
            $rencontre->addEquipe($equipesAdversesRL[$data['adversaire']]);

            $manager->persist($rencontre);
        }

        // 9️⃣ Matchs COD
        $matchsCOD = [
            ['date' => '2025-12-01', 'adversaire' => 'Optic Gaming',        'resultat' => '4 : 1'],
            ['date' => '2025-12-01', 'adversaire' => 'Optic Gaming',        'resultat' => '3 : 2'],
            ['date' => '2025-11-30', 'adversaire' => 'Los Angeles Thieves', 'resultat' => '3 : 1'],
        ];

        foreach ($matchsCOD as $data) {
            $rencontre = new Rencontre();
            $rencontre->setDate(new DateTime($data['date']));
            $rencontre->setJeu('Call of duty'); // pareil, adapte si ton front attend 'cod'
            $rencontre->setResultat($data['resultat']);

            $rencontre->addEquipe($gentlemates);
            $rencontre->addEquipe($equipesAdversesCOD[$data['adversaire']]);

            $manager->persist($rencontre);
        }

        $manager->flush();
    }
}




 