<?php

namespace App\Controller;

use App\Entity\Rencontre;
use App\Form\RencontreType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Equipe;
use App\Repository\RencontreRepository;

use Symfony\Component\Routing\Attribute\Route;

final class RencontreController extends AbstractController
{
    #[Route('/rencontre', name: 'app_rencontre', methods: ['GET'])]
    public function index(RencontreRepository $rencontreRepository): Response
    {
        $rencontres = $rencontreRepository->findAll();

        return $this->render('rencontre/index.html.twig', [
            'rencontres' => $rencontres,
        ]);
    }

    #[Route('/rencontre/ajouter', name: 'app_rencontre_ajouter')]
    public function ajouter(EntityManagerInterface $em): Response
    {
        $rencontre = new Rencontre();
        $rencontre->setDate(new \DateTime());
        $rencontre->setResultat('En cours');
        $rencontre->setJeu('Valorant');

        $equipeRepo = $em->getRepository(Equipe::class);
        $equipe1 = $equipeRepo->find(1);
        $equipe2 = $equipeRepo->find(2);

        if ($equipe1){
            $rencontre->addRencontre($equipe1);
        }

        if ($equipe2){
            $rencontre->addRencontre($equipe2);
        }

        $em->persist($rencontre);
        $em->flush();

        return new Response('Rencontre ajoutée' . $rencontre->getId());
    }

    #[Route('/rencontre/{id}', name: 'app_rencontre_show', methods: ['GET'])]
    public function show(Rencontre $rencontre): Response
    {
        return $this->render('rencontre/show.html.twig', [
            'rencontre' => $rencontre,
        ]);
    }
}
