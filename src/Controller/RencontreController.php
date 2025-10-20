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
    public function publique(RencontreRepository $rencontreRepository): Response
    {
        $rencontres = $rencontreRepository->findBy([], [
            'date' => 'DESC'
        ]);

        
        $rencontresParJeu = [];
        foreach ($rencontres as $rencontre){
            $jeu = $rencontre->getJeu();
            if(!isset($rencontresParJeu[$jeu])){
                $rencontresParJeu[$jeu] = [];
            }
            $rencontresParJeu[$jeu][] = $rencontre;
        }

        return $this->render('rencontre/publique.html.twig', [
            'rencontresParJeu' => $rencontresParJeu,
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