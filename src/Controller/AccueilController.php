<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AccueilController extends AbstractController
{
    #[Route('/accueil', name: 'app_accueil')]
    public function index(): Response
    {
    $title = "Bienvenue sur mon site Symfony !";
    $message = "Ceci est ma première page d'accueil avec Symfony 🚀";

    return $this->render('accueil/index.html.twig', [
        'title' => $title,
        'message' => $message,
    ]);
}
}