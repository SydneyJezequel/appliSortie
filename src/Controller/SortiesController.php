<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Sortie;
use App\Form\CreerSortieType;
use App\Form\FiltreType;
use App\Form\InscriptionSortieFormType;
use App\Modele\Filtre;
use App\Repository\CampusRepository;
use App\Repository\EtatRepository;
use App\Repository\LieuRepository;
use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Proxies\__CG__\App\Entity\Campus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class SortiesController extends AbstractController
{


    /**
     * @Route("/sorties", name="sorties_afficher", methods={"GET", "POST"})
     */
    public function afficherSorties(ParticipantRepository $participantRepository, Request $request, SortieRepository $sortieRepository)
    {
        $filtre = new Filtre();
        $filtre->campus=$this->getUser()->getCampus();
        $idUser=$this->getUser()->getUserIdentifier();
        $user= $participantRepository->findBy(['email'=>$idUser]);
        $filtre->id = $user[0]->getId();
        $form = $this->createForm(FiltreType::class, $filtre);
        $form->handleRequest($request);
        $sorties = $sortieRepository->searchSorties($filtre);
        return $this->render('sorties/afficher.html.twig', [
            'form' => $form->createView(),
            'sorties'=> $sorties,
        ]);

    }

    /**
     * @Route("/creer/sortie", name="app_creer_sortie", methods={"GET","POST"})
     */
    public function creerSortie(Request $request, EntityManagerInterface $manager,
                                LieuRepository $lieuRepository, EtatRepository $etatRepository): Response
    {
        $nouvelleSortie = new Sortie();
        $organisateur = $this->getUser();
        $campus = $organisateur->getCampus();
        $nouvelleSortie->setOrganisateur($organisateur);
        $nouvelleSortie->setCampus($campus);
        $nouvelleSortie->setEtat($etatRepository->findOneBy(['libelle'=>'en cr??ation']));
        // Etat temporaire :
        $form = $this->createForm(CreerSortieType::class, $nouvelleSortie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ('Publier' === $form->getClickedButton()->getName()) {
                $nouvelleSortie->setEtat($etatRepository->findOneBy(['libelle'=>'ouverte']));
            }
            // R??cup??ration des donn??es du formulaire :
            $nouvelleSortie = $form->getData();
            // Injection des donn??es :
            $manager->persist($nouvelleSortie);
            $manager->flush();
            $this->addFlash(
                'ok',
                'La sortie a ??t?? cr????e.'
            );
            return $this->redirectToRoute('app_creer_sortie', ['id'=>$organisateur->getId()]);
        }
        return $this->render('sorties/creerSortie.html.twig', [

            'formulaire' => $form->createView(),
        ]);
    }

    /**
     * @Route("/inscriptionSortie/{id}", name="app_inscription_sortie", methods={"GET", "POST"})
     */
    public function inscriptionSortie(Sortie $sortie, Request $request, EntityManagerInterface $entityManager): Response
    {
            $participant = $this->getUser();

            $sortie->addInscrit($participant);
            // Injection des donn??es :
            $entityManager->flush($sortie);
            $this->addFlash('suscribed', 'Vous ??tes inscrit.');

            return $this->redirectToRoute('sorties_afficher');

    }

    /**
     * @Route("/desistementSortie/{id}", name="app_desistement_sortie", methods={"GET", "POST"})
     */
    public function desistementSortie(Sortie $sortie, Request $request, EntityManagerInterface $entityManager): Response
    {
            $participant = $this->getUser();

            $sortie->removeInscrit($participant);

            // Injection des donn??es :
            $entityManager->flush($sortie);

            $this->addFlash('unsuscribed', 'Vous ??tes d??sinscrit.');

            return $this->redirectToRoute('sorties_afficher');

    }


    /**
     * @Route("/sorties/edit", name="edit_sortie")
     */
    public function edit(Sortie $sortie, Request $request, EntityManagerInterface $em)
    {

    }


    /**
     * @Route("/sorties", name="afficher_sortie")
     */
    public function affichersortie(Sortie $sortie, Request $request, EntityManagerInterface $em)
    {

    }


    /**
     * @Route("/sorties/addParticipant", name="add_participant_sortie")
     */
    public function add_participant(EntityManagerInterface $em, Request $request, Sortie $sortie){

    }


    /**
     * @Route("/sorties/supprimerParticipant/{id}", name="supprimer_participant_sortie")
     */
    public function supprimer_participant(EntityManagerInterface $em, Request $request){

    }


    /**
     * @Route("/sorties/annuler/{id}", name="annuler_sortie")
     */
    public function annuler_sortie(Request $request, EntityManagerInterface $em, Sortie $sortie){


    }
}