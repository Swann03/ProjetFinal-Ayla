<?php

namespace App\Controller;

use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EffaceMoiController extends AbstractController
{
    #[Route('/efface/moi', name: 'app_efface_moi')]
    public function index(): Response
    {
        return $this->render('efface_moi/index.html.twig', [
            'controller_name' => 'EffaceMoiController',
        ]);
    }

    #[Route('/exemple/insert')]
    public function insertCategorie(EntityManagerInterface $manager){
        $categorie1 = new Categorie();
        $categorie1->setNom('boissons');

        $manager->persist($categorie1);
        $manager->flush();
        return new Response("Categorie insérées");
        
    }
}
