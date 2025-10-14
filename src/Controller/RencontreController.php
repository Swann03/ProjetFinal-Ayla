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
    #[IsGranted('ROLE_ADMIN')]
    public function index(RencontreRepository $rencontreRepository): Response
    {
        $rencontres = $rencontreRepository->findBy([], [
            'date' => 'DESC'
        ]);

        // Création du formulaire pour l'afficher dans la page index
        $rencontre = new Rencontre();
        $form = $this->createForm(RencontreType::class, $rencontre);

        return $this->render('rencontre/index.html.twig', [
            'rencontres' => $rencontres,
            'form' => $form->createView(), // Ajout de la variable form
        ]);
    }

    #[Route('/rencontre/ajouter', name: 'app_rencontre_ajouter', methods: ['POST'])]
    
    public function ajouter(Request $request, EntityManagerInterface $em): Response
    {
        $rencontre = new Rencontre();
        $form = $this->createForm(RencontreType::class, $rencontre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($rencontre);
            $em->flush();

            if ($request->isXmlHttpRequest()) {
                return $this->json([
                    'success' => true,
                    'id' => $rencontre->getId(),
                    'jeu' => $rencontre->getJeu(),
                    'resultat' => $rencontre->getResultat(),
                    'date' => $rencontre->getDate()->format('d/m/Y H:i')
                ]);
            }

            $this->addFlash('success', 'Rencontre ajoutée avec succès !');
            return $this->redirectToRoute('app_rencontre');
        }

       
        if ($request->isXmlHttpRequest() && $form->isSubmitted()) {
            $errors = [];
            foreach ($form->getErrors(true) as $error) {
                $errors[] = $error->getMessage();
            }
            
            return $this->json([
                'success' => false,
                'errors' => $errors
            ], Response::HTTP_BAD_REQUEST);
        }

        return $this->redirectToRoute('app_rencontre');
    }
    
    #[Route('/rencontre/{id}', name: 'app_rencontre_show', methods: ['GET'])]
    public function show(Rencontre $rencontre): Response
    {
        return $this->render('rencontre/show.html.twig', [
            'rencontre' => $rencontre,
        ]);
    }
 }