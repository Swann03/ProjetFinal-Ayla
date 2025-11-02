<?php

namespace App\Controller;

use App\Entity\Rencontre;
use App\Form\RencontreType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\RencontreRepository;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class RencontreController extends AbstractController
{
    #[Route('/rencontre', name: 'app_rencontre', methods: ['GET'])]
public function publique(RencontreRepository $rencontreRepository): Response
{
    $rencontres = $rencontreRepository->findBy([], ['date' => 'DESC']);
    $now = new \DateTime();

    $rencontresParJeu = [];

    foreach ($rencontres as $rencontre) {
        $jeu = $rencontre->getJeu();

        // Si la clé du jeu n'existe pas encore, on l'initialise
        if (!isset($rencontresParJeu[$jeu])) {
            $rencontresParJeu[$jeu] = [
                'avenir' => [],
                'termines' => [],
            ];
        }

        // Classement selon la date
        if ($rencontre->getDate() > $now) {
            $rencontresParJeu[$jeu]['avenir'][] = $rencontre;
        } else {
            $rencontresParJeu[$jeu]['termines'][] = $rencontre;
        }
    }

    return $this->render('rencontre/publique.html.twig', [
        'rencontresParJeu' => $rencontresParJeu,
    ]);
}


    #[Route('/rencontre/ajouter', name: 'app_rencontre_ajouter', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function ajouter(Request $request, EntityManagerInterface $em): Response
    {
        $rencontre = new Rencontre();
        $form = $this->createForm(RencontreType::class, $rencontre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($rencontre);
            $em->flush();

            $this->addFlash('success', '✅ Rencontre ajoutée avec succès.');
            return $this->redirectToRoute('app_rencontre');
        }

        return $this->render('rencontre/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/rencontre/{id}', name: 'app_rencontre_show', methods: ['GET'])]
    public function show(Rencontre $rencontre): Response
    {
        return $this->render('rencontre/show.html.twig', [
            'rencontre' => $rencontre,
        ]);
    }
}
