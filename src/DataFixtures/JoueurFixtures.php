<?php

namespace App\DataFixtures;

use App\Entity\Joueur;
use App\Entity\Equipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class JoueurFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [
            EquipeFixtures::class,
        ];
    }

    public function load(ObjectManager $manager): void
    {
        /**
         * 🔹 JOUEURS VALORANT
         */
        $valorant = $manager->getRepository(Equipe::class)->findOneBy(['nom' => 'VALORANT']);

        if (!$valorant) {
            throw new \RuntimeException('⚠️ L’équipe VALORANT doit exister avant d’ajouter les joueurs. Lance d’abord EquipeFixtures.');
        }

        $joueursValorant = [
            [
                'nom' => 'Berkcan Şentürk',
                'pseudo' => 'Comeback',
                'bio' => 'Berkcan "ComeBack" Şentürk est un joueur turc de 17 ans. Il a rejoint Gentle Mates en 2025 et s’est imposé comme un talent prometteur sur la scène européenne.'
            ],
            [
                'nom' => 'Patrik Hušek',
                'pseudo' => 'Minny',
                'bio' => 'Patrik "Minny" Hušek est un joueur tchèque. Actif depuis 2020, il a rejoint Gentle Mates fin 2024 avec un parcours impressionnant.'
            ],
            [
                'nom' => 'Maks Rychlewski',
                'pseudo' => 'Kamyk',
                'bio' => 'Maks "Kamyk" Rychlewski est un joueur polonais, actif depuis 2020. Il a rejoint Gentle Mates en 2024 après une belle performance sur la scène Valorant East.'
            ],
            [
                'nom' => 'Sylvain Pattyn',
                'pseudo' => 'Veqaj',
                'bio' => 'Sylvain "Veqaj" Pattyn a rejoint Gentle Mates en 2025. MVP à la Spotlight Series EMEA 2024, il est une pièce maîtresse de l’équipe.'
            ],
            [
                'nom' => 'Emre Tunc',
                'pseudo' => 'Proxh',
                'bio' => 'Yusuf "Proxh" Emre Tunc, joueur allemand, a d’abord rejoint Gentle Mates en prêt depuis Eintracht Frankfurt avant d’être signé définitivement.'
            ],
        ];

        foreach ($joueursValorant as $data) {
            $joueur = new Joueur();
            $joueur->setNom($data['nom']);
            $joueur->setPseudo($data['pseudo']);
            $joueur->setBio($data['bio']);
            $joueur->setEquipe($valorant);

            $manager->persist($joueur);
        }

        /**
         * 🔹 JOUEURS COUNTER STRIKE 2
         */
        $cs2 = $manager->getRepository(Equipe::class)->findOneBy(['nom' => 'COUNTER STRIKE 2']);

        if (!$cs2) {
            throw new \RuntimeException('⚠️ L’équipe COUNTER STRIKE 2 doit exister avant d’ajouter les joueurs. Lance d’abord EquipeFixtures.');
        }

        $joueursCs2 = [
            [
                'nom' => 'David Granado Bermudo',
                'pseudo' => 'dav1g',
                'bio' => 'David "dav1g" Granado Bermudo est un sniper espagnol, connu pour son style agressif et ses réflexes surhumains.'
            ],
            [
                'nom' => 'Antonio Martinez Sanchez',
                'pseudo' => 'Martinez',
                'bio' => 'Antonio "Martinez" Martinez Sanchez est un rifler jeune et explosif, au potentiel immense sur la scène Counter-Strike.'
            ],
            [
                'nom' => 'Pere Solsona Saumell',
                'pseudo' => 'sausoL',
                'bio' => 'Pere "sausoL" Solsona Saumell, très bon support.'
            ],
            [
                'nom' => 'Alejandro Fernandez-Quejo Cano',
                'pseudo' => 'Mopoz',
                'bio' => 'Alejandro "Mopoz" Fernandez-Quejo Cano est un joueur polyvalent espagnol, capable de s’adapter à toutes les situations.'
            ],
            [
                'nom' => 'Alejandro Masanet Candela',
                'pseudo' => 'Alex',
                'bio' => "Alejandro \"Alex\" Masanet Candela, joueur d’expérience, est un pilier de l’équipe et un meneur calme."
            ],
        ];

        foreach ($joueursCs2 as $data) {
            $joueur = new Joueur();
            $joueur->setNom($data['nom']);
            $joueur->setPseudo($data['pseudo']);
            $joueur->setBio($data['bio']);
            $joueur->setEquipe($cs2);

            $manager->persist($joueur);
        }

        /**
         * JOUEURS CALL OF DUTY
         */
        $cod = $manager->getRepository(Equipe::class)->findOneBy(['nom' => 'CALL OF DUTY']);

        if (!$cod) {
            throw new \RuntimeException('⚠️ L’équipe CALL OF DUTY doit exister avant d’ajouter les joueurs. Lance d’abord EquipeFixtures.');
        }

        $joueursCod = [
            [
                'nom' => 'Daniel Rothe',
                'pseudo' => 'Ghosty',
                'bio' => 'Daniel "Ghosty" Rothe est un sniper américain, connu pour son style agressif et ses réflexes surhumains.'
            ],
            [
                'nom' => 'Dylan Hannon',
                'pseudo' => 'Envoy',
                'bio' => 'Dylan "Envoy" Hannon est un rifler jeune et explosif, au potentiel immense sur la scène Call of Duty.'
            ],
            [
                'nom' => 'Travis McCloud',
                'pseudo' => 'NNeptuunE',
                'bio' => 'Travis "NNeptuunE" McCloud est un support jeune et explosif, au potentiel immense sur la scène Call of Duty.'
            ],
            [
                'nom' => 'Daunt Gray',
                'pseudo' => 'Sib',
                'bio' => 'Daunt "Sib" Gray est un joueur polyvalent americain, capable de s’adapter à toutes les situations.'
            ],
        ];

        foreach ($joueursCod as $data) {   
            $joueur = new Joueur();
            $joueur->setNom($data['nom']);
            $joueur->setPseudo($data['pseudo']);
            $joueur->setBio($data['bio']);
            $joueur->setEquipe($cod);
            $manager->persist($joueur);
        }

        /**
         * 🔹 JOUEURS FORTNITE
         */
        $fortnite = $manager->getRepository(Equipe::class)->findOneBy(['nom' => 'FORTNITE']);

        if (!$fortnite) {
            throw new \RuntimeException('⚠️ L’équipe FORTNITE doit exister avant d’ajouter les joueurs. Lance d’abord EquipeFixtures.');
        }

        $joueursFortnite = [
            [
                'nom' => 'Vanya Sakach',
                'pseudo' => 'vanyak3k',
                'bio' => 'Vanya « Vanyak3k » Sakach est un joueur professionnel de Fortnite. Après s être fait connaître en 2022, il a participé aux FBCS Globals 2023 et a remporté sa première grande finale FNCS en mai 2024. Avec Gentle Mates, qu il a rejoint en juin 2024, il espère aller encore plus loin dans sa carrière.'
            ],
            [
                'nom' => 'Kenzo Leroux',
                'pseudo' => 'Akiira',
                'bio' => 'Kenzo « Akiira » Leroux est un joueur professionnel de Fortnite qui a rejoint Gentle Mates en décembre 2024. Bien qu il ait débuté sa carrière récemment, en 2023, il a déjà participé deux fois à la grande finale de la FNCS !'
            ],
            [
                'nom' => 'Andrejs Piratovs',
                'pseudo' => 'Merstach',
                'bio' => 'Andrejs « Merstach » Piratovs est un joueur professionnel de Fortnite qui a débuté sa carrière en 2021. Fort de deux victoires en finale du FNCS Grand Finals, il a rejoint Gentle Mates en décembre 2024. Malgré son jeune âge, il affiche déjà un palmarès impressionnant.'
            ],
            [
                'nom' => 'Miguel Moreno',
                'pseudo' => 'Pollo',
                'bio' => 'Miguel « Pollo » Moreno est un joueur professionnel de Fortnite. En 2024, il remporte le FNCS Global Championship et devient champion du monde. Grâce à ses excellents résultats depuis le début de l année, il s est déjà qualifié pour la compétition de cette année, qu il espère remporter une nouvelle fois !'
            ],
            [
                'nom' => 'Marius Wendt',
                'pseudo' => 'MariusCOW',
                'bio' => 'Marius « MariusCOW » Wendt est un joueur professionnel danois de Fortnite qui a rejoint Gentle Mates en 2025. Il participera cette année pour la première fois de sa carrière au championnat mondial FNCS !'
            ],
        ];

        foreach ($joueursFortnite as $data) {   
            $joueur = new Joueur();
            $joueur->setNom($data['nom']);
            $joueur->setPseudo($data['pseudo']);
            $joueur->setBio($data['bio']);
            $joueur->setEquipe($fortnite);
            $manager->persist($joueur);
        }

        /**
         * 🔹 JOUEURS Rocket
         */
        $rocketleague = $manager->getRepository(Equipe::class)->findOneBy(['nom' => 'ROCKET LEAGUE']);

        if (!$rocketleague) {
            throw new \RuntimeException('⚠️ L’équipe Rocket League doit exister avant d’ajouter les joueurs. Lance d’abord EquipeFixtures.');
        }

        $joueursrocketleague = [
            [
                'nom' => 'Archie Pickthall',
                'pseudo' => 'Archie',
                'bio' => 'Archie est un joueur britannique réputé pour son intelligence de jeu, son placement impeccable et sa constance en compétition. Ancien joueur de Top Teams comme Endpoint et Karmine Corp, il apporte stabilité et expérience au trio.'
            ],
            [
                'nom' => 'Nassim Bali',
                'pseudo' => 'Nass',
                'bio' => 'Nass est un joueur belgo-marocain en pleine ascension, apprécié pour sa vitesse, son agressivité contrôlée et ses capacités de clutch. Après son passage remarqué chez Tundra et NIP, il est aujourd’hui considéré comme l’un des talents les plus prometteurs de la scène européenne.'
            ],
            [
                'nom' => 'Oskar',
                'pseudo' => 'Oski',
                'bio' => 'Oski est un jeune prodige polonais reconnu pour sa mécanique aérienne exceptionnelle et sa créativité en match. Passé par Team Liquid puis Ninjas in Pyjamas, il s’impose comme l’un des joueurs les plus explosifs de la scène RLCS.'
            ],
        ];

        foreach ($joueursrocketleague as $data) {   
            $joueur = new Joueur();
            $joueur->setNom($data['nom']);
            $joueur->setPseudo($data['pseudo']);
            $joueur->setBio($data['bio']);
            $joueur->setEquipe($rocketleague);
            $manager->persist($joueur);
        }

        /**
         * 🔹 JOUEURS Warzone
         */
        $warzone = $manager->getRepository(Equipe::class)->findOneBy(['nom' => 'CALL OF DUTY WARZONE']);

        if (!$warzone) {
            throw new \RuntimeException('⚠️ L’équipe Rocket League doit exister avant d’ajouter les joueurs. Lance d’abord EquipeFixtures.');
        }

        $joueurswarzone = [
            [
                'nom' => 'Enzo Giorgi',
                'pseudo' => 'Enkeo',
                'bio' => 'Enkeo est un joueur explosif, connu pour ses déplacements rapides et sa maîtrise des combats rapprochés. Toujours prêt à créer l’ouverture décisive, il est l’un des éléments les plus imprévisibles et dangereux du roster.'
            ],
            [
                'nom' => 'Tom Lejeune',
                'pseudo' => 'HalloW',
                'bio' => 'Hallow se distingue par son sens du jeu exceptionnel et sa capacité à anticiper les rotations adverses. Sa vision tactique et son leadership naturel apportent stabilité et stratégie à l’équipe.'
            ],
            [
                'nom' => 'Valentin Lafon',
                'pseudo' => 'Gromalok',
                'bio' => 'Gromalok est un joueur Warzone réputé pour son sang-froid et sa précision chirurgicale en duel. Son style agressif mais structuré en fait un atout majeur dans les fins de partie sous pression.'
            ],
        ];

        foreach ($joueurswarzone as $data) {   
            $joueur = new Joueur();
            $joueur->setNom($data['nom']);
            $joueur->setPseudo($data['pseudo']);
            $joueur->setBio($data['bio']);
            $joueur->setEquipe($warzone);
            $manager->persist($joueur);
        }

        $manager->flush();
    }
}
