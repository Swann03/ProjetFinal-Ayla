<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Repository\RencontreRepository;
use App\Repository\VoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Rencontre;
use App\Entity\Vote;

#[Route('/vote')]
#[IsGranted('ROLE_USER')]
final class VoteController extends AbstractController
{
        #[Route('/', name: 'app_vote', methods: ['GET'])]
        public function index(
            RencontreRepository $rencontreRepository,
            VoteRepository $voteRepository
        ): Response
        {
            $utilisateur = $this->getUser();
            $rencontres = $rencontreRepository->findAll();
            return $this->render('vote/index.html.twig', [
                'rencontres' => $rencontres,
            ]);
        }
        
        #[Route('/soumettre/{id}', name: 'app_vote_soumettre', methods: ['POST'])]
        public function soumettre(
            Rencontre $rencontre,
            Request $request,
            EntityManagerInterface $em,
            VoteRepository $voteRepository
        ): Response
        {
            $utilisateur = $this->getUser();

            $voteExistant = $voteRepository->findOneBy([
                'rencontre' => $rencontre,
                'utilisateur' => $utilisateur,
            ]);

            if ($voteExistant) {
                $this->addFlash('error', 'Vous avez déjà voté pour cette rencontre !');
                return $this->redirectToRoute('app_rencontre');
            }

            if ($rencontre->getDateMatch() && $rencontre->getDateMatch() <= new \DateTimeImmutable()) {
                $this->addFlash('error', 'La rencontre est déjà passée !');
                return $this->redirectToRoute('app_rencontre');
            }

            if (!empty($rencontre->getResultat())) {
                $this->addFlash('error', 'La rencontre est terminé !');
                return $this->redirectToRoute('app_rencontre');
            }

            $equipeId = $request->request->get('equipe_id');
            
            if (!$equipeId) {
                $this->addFlash('error', 'Veuillez selectionner une equipe ');
                return $this->redirectToRoute('app_rencontre');
            }

            // Verifie que l'equipe est bien dans la rencontre

            $equipeVotee = null;
            foreach ($rencontre->getRencontre() as $equipe){
                if ($equipe->getId() == $equipeId) {
                    $equipeVotee = $equipe;
                    break;
                }
            }

            if (!$equipeVotee) {
                $this->addFlash('error', 'Equipe non trouvée !');
                return $this->redirectToRoute('app_rencontre');
            }

            $vote = new Vote();
            $vote->setEquipe($equipeVotee);
            $vote->setRencontre($rencontre);
            $vote->setUtilisateur($utilisateur);
            $vote->setPoint(null);
            
            $em->persist($vote);
            $em->flush();
            
            $this->addFlash('success', 'Votre vote a été enregistré');
            return $this->redirectToRoute('app_rencontre');
        }
}
