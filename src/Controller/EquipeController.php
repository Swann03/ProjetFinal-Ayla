<?php

namespace App\Controller;

use App\Repository\EquipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class EquipeController extends AbstractController
{
    #[Route('/equipe', name: 'app_equipe')]
    public function index(EquipeRepository $equipeRepository): Response
    {
        // ✅ On récupère uniquement les équipes du club (pas Gentlemates, pas les adversaires)
        $equipes = $equipeRepository->createQueryBuilder('e')
            ->where('e.isAdversaire = false')
            ->andWhere('e.isClubPrincipal = false')
            ->orderBy('e.nom', 'ASC')
            ->getQuery()
            ->getResult();

        return $this->render('equipe/index.html.twig', [
            'equipes' => $equipes,
        ]);
    }
}
