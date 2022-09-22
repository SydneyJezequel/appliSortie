<?php

namespace App\Controller\Api\Controller;

use App\Entity\Participant;
use App\Entity\Sortie;
use App\Form\CreerSortieType;
use App\Repository\EtatRepository;
use App\Repository\LieuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreerSortieController extends AbstractController
{
    /**
     * @Route("/creer/sortie/{id}", name="app_creer_sortie", methods={"GET","POST"})
     */
    public function creerSortie(Participant $organisateur, Request $request, EntityManagerInterface $manager,
                                LieuRepository $lieuRepository, EtatRepository $etatRepository): Response
    {
        $lieuListe = $lieuRepository->findAll();
        $etat = $etatRepository->findAll();
        $nouvelleSortie = new Sortie();
        // Récupération de l'id de l'organisateur :
        $nouvelleSortie->setOrganisateur($organisateur);
        // Récupération de l'id du campus :
        $campus = $organisateur->getCampus();
        $nouvelleSortie->setCampus($campus);
        $nouvelleSortie->setEtat($etatRepository->findOneBy(['libelle'=>'en création']));
        // Etat temporaire :
        $form = $this->createForm(CreerSortieType::class, $nouvelleSortie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ('Publier' === $form->getClickedButton()->getName()) {
                $nouvelleSortie->setEtat($etatRepository->findOneBy(['libelle'=>'ouverte']));
            }
            // Récupération des données du formulaire :
            $nouvelleSortie = $form->getData();
            // Injection des données :
            $manager->persist($nouvelleSortie);
            $manager->flush();
            $this->addFlash(
                'ok',
                'La sortie a été crée.'
            );
            return $this->redirectToRoute('app_creer_sortie', ['id'=>$organisateur->getId()]);
        }
            return $this->render('sortie/creerSortie.html.twig', [

                'formulaire' => $form->createView(),
            ]);
    }


}
