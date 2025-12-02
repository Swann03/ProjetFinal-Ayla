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
        // Récupération ou création de l’équipe GENTLEMATES (club principal)
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

        //Adversaires VALORANT
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

        // Adversaires CS2
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

        // Adversaires ROCKET LEAGUE
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
            $equipesAdversesCOD[$nom] = $equipe;
        }

        
        $manager->flush();

        // Matchs VALORANT
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
            $rencontre->setJeu('Valorant');
            $rencontre->setResultat($data['resultat']);

            $rencontre->addEquipe($gentlemates);
            $rencontre->addEquipe($equipesAdversesValorant[$data['adversaire']]);

            $manager->persist($rencontre);
        }

        // Matchs CS2
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
            $rencontre->setJeu('Counter Strike 2');
            $rencontre->setResultat($data['resultat']);

            $rencontre->addEquipe($gentlemates);
            $rencontre->addEquipe($equipesAdversesCs2[$data['adversaire']]);

            $manager->persist($rencontre);
        }

        // Matchs ROCKET LEAGUE
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
            $rencontre->setJeu('Rocket League'); 
            $rencontre->setResultat($data['resultat']);

            $rencontre->addEquipe($gentlemates);
            $rencontre->addEquipe($equipesAdversesRL[$data['adversaire']]);

            $manager->persist($rencontre);
        }

        // Matchs COD
        $matchsCOD = [
            ['date' => '2025-12-01', 'adversaire' => 'Optic Gaming',        'resultat' => '4 : 1'],
            ['date' => '2025-12-01', 'adversaire' => 'Optic Gaming',        'resultat' => '3 : 2'],
            ['date' => '2025-11-30', 'adversaire' => 'Los Angeles Thieves',        'resultat' => '3 : 1'],
        ];

        foreach ($matchsCOD as $data) {
            $rencontre = new Rencontre();
            $rencontre->setDate(new DateTime($data['date']));
            $rencontre->setJeu('Call of duty'); 
            $rencontre->setResultat($data['resultat']);

            $rencontre->addEquipe($gentlemates); 
            $rencontre->addEquipe($equipesAdversesCOD[$data['adversaire']]);

            $manager->persist($rencontre);
        }
         $repo = $manager->getRepository(Equipe::class);

        $gentlematesEquipes = $repo->findBy(['isAdversaire' => false]);
        $adversairesEquipes = $repo->findBy(['isAdversaire' => true]);

        if (empty($gentlematesEquipes) || empty($adversairesEquipes)) {
            throw new \Exception("Il faut au moins une équipe club et une équipe adversaire en BDD.");
        }

        $now = new \DateTimeImmutable();

        for ($i = 1; $i <= 5; $i++) {
            $r = new Rencontre();
            $r->setDate(\DateTime::createFromImmutable($now->modify("+$i days")));
            $r->setJeu("VALORANT");
            $r->setResultat("À venir");

            $gentlemates = $gentlematesEquipes[array_rand($gentlematesEquipes)];
            $adversaire = $adversairesEquipes[array_rand($adversairesEquipes)];

            $r->addEquipe($gentlemates);
            $r->addEquipe($adversaire);

            $manager->persist($r);
        }

        $manager->flush();
    }
}




 