<?php

namespace App\Controller;

use App\Entity\Vote;
use App\Repository\RencontreRepository;
use App\Repository\VoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/vote')]
class VoteController extends AbstractController
{
    #[Route('/', name: 'app_vote')]
    public function index(
        Request $request,
        RencontreRepository $rencontreRepository,
        VoteRepository $voteRepository,
        EntityManagerInterface $em
    ): Response {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException();
        }

        // matchs futurs Valorant
        $rencontres = $rencontreRepository->createQueryBuilder('r')
            ->where('r.date > :now')
            ->andWhere('r.jeu = :jeu')
            ->setParameter('now', new \DateTimeImmutable())
            ->setParameter('jeu', 'VALORANT')
            ->getQuery()
            ->getResult();

        if ($request->isMethod('POST')) {
            $id = $request->request->get('rencontre_id');
            $choix = $request->request->get('choix'); // "GENTLEMATES" ou "ADVERSAIRE"

            $rencontre = $rencontreRepository->find($id);

            if ($rencontre) {
                $voteExistant = $voteRepository->findOneBy([
                    'utilisateur' => $user,
                    'rencontre' => $rencontre
                ]);

                if ($voteExistant) {
                    $this->addFlash('warning', 'Tu as déjà voté pour ce match.');
                } else {
                    $equipe = $choix === 'GENTLEMATES'
                        ? $rencontre->getEquipeGentlemates()
                        : $rencontre->getEquipeAdversaire();

                    if ($equipe === null) {
                        $this->addFlash('danger', 'Configuration de match invalide.');
                    } else {
                        $vote = new Vote();
                        $vote->setUtilisateur($user);
                        $vote->setRencontre($rencontre);
                        $vote->setEquipe($equipe);
                        $vote->setChoix($choix);

                        $em->persist($vote);
                        $em->flush();

                        $this->addFlash('success', 'Vote enregistré ✅');
                    }
                }
            }

            return $this->redirectToRoute('app_vote');
        }

        return $this->render('vote/index.html.twig', [
            'rencontres' => $rencontres,
        ]);
    }

#[Route('/classement', name: 'app_vote_classement')]
public function classement(VoteRepository $voteRepository): Response
{
    $votes = $voteRepository->findAll();

    $classement = [];

    foreach ($votes as $vote) {
        $user = $vote->getUtilisateur();
        if (!$user) {
            continue;
        }

        $id = $user->getId();

        if (!isset($classement[$id])) {
            $classement[$id] = [
                'nom'   => $user->getNom(), 
                'votes' => 0,
            ];
        }

        $classement[$id]['votes']++;
    }

    // on passe à un tableau indexé
    $classement = array_values($classement);
    // tri décroissant par nb de votes
    usort($classement, fn($a, $b) => $b['votes'] <=> $a['votes']);

    return $this->render('vote/classement.html.twig', [
        'classement' => $classement,
    ]);
}


}

