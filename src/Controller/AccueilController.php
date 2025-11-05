<?php



namespace App\Controller;

use App\Repository\RencontreRepository;
use App\Repository\EquipeRepository;
use App\Repository\VoteRepository;
use App\Repository\MediaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/accueil', name: 'app_accueil')]
    public function index(
        RencontreRepository $rencontreRepo,
        EquipeRepository $equipeRepo,
        VoteRepository $voteRepo,
        MediaRepository $mediaRepo
    ): Response {
        // Récupérer les données de la BDD
        $prochainsMatchs = $rencontreRepo->findBy([], ['date' => 'ASC'], 3);
        $equipe = $equipeRepo->findOneBy(['nom' => 'Gentlemates']); // Si tu as un champ nom
        $votes = $voteRepo->findBy([], ['id' => 'DESC'], 1); // Dernier vote actif
        $medias = $mediaRepo->findBy([], [], 4);

        // Données pour le m8banner
        $banniere = [
            'titre' => 'GENTLEMATES OFFICIAL ESPORTS TEAM',
            'sousTitre' => 'ALWAYS GENTLE, ALWAYS STRONG',
            'ctaLabel' => 'JOIN THE COMMUNITY',
            'ctaLien' => '#',  // Lien vers le lien Discord ou ta page communauté
            'imageFond' => 'hero-gentlemates.jpg', // Place cette image dans public/images
        ];

        return $this->render('accueil/index.html.twig', [
            'banniere' => $banniere,
            'prochainsMatchs' => $prochainsMatchs,
            'equipe' => $equipe,
            'votes' => $votes,
            'medias' => $medias,
        ]);
    }
}
