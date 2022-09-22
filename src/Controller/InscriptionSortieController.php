<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Sortie;
use App\Form\FiltreType;
use App\Form\InscriptionSortieFormType;
use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionSortieController extends AbstractController
{
    /**
     * @Route("/inscriptionSortie/{id}", name="app_inscription_sortie", methods={"GET", "POST"})
     */
    public function inscriptionSortie($id, Request $request, EntityManagerInterface $entityManager,Sortie $sortie, SortieRepository $sortieRepository, Participant $participant): Response
    {
//        $user = $participant.$this->getUser();

//        $listeInscrits = $sortie->getInscrits();
//        dd($listeInscrits);
        $participant = $this->getUser();
        dd($participant);
//        $participant= $participantRepository->findBy(['email'=>$emailUser]);
//        dd($participant);
        $sortie = $sortieRepository->find(1);
//        dd($sortie);
//        $sortie->addInscrit($participant);
        $form = $this->createForm(InscriptionSortieFormType::class);
        $form->handleRequest($request);
//        dump($form);


        if ($form->isSubmitted() && $form->isValid()) {

//        $sortie = $sortieRepository->find($id);
        $sortie = $sortieRepository->find($form['id_sortie']->getData());
//        dd($sortie);
            // Récupération des données du formulaire :
            $inscriptionSortie = $sortie;
        $sortie->addInscrit($participant);
//            dd($inscriptionSortie);
            // Injection des données :
//            $entityManager->persist($inscriptionSortie);
            $entityManager->flush($inscriptionSortie);
            $this->addFlash('ok','Vous êtes inscrit.');

            return $this->redirectToRoute('app_inscription_sortie', [
                    'id' => $inscriptionSortie->getId()
            ]);
        }






//        //        $user = $participant.$this->getUser();
//
////        $listeInscrits = $sortie->getInscrits();
////        dd($listeInscrits);
//        $participant = $this->getUser();
////        dd($emailUser);
////        $participant= $participantRepository->findBy(['email'=>$emailUser]);
////        dd($participant);
////        dd($sortie);
//        $sortie = null;
//        $sortie = $sortieRepository->find($id);
//        $sortie->addInscrit($participant);
//        $form = $this->createForm(InscriptionSortieFormType::class);
//        $form->handleRequest($request);
//        dump($form);
//        if ($form->isSubmitted() && $form->isValid()) {
//
//            // Récupération des données du formulaire :
//            $inscriptionSortie = $sortie;
////            dd($inscriptionSortie);
//            // Injection des données :
////            $entityManager->persist($inscriptionSortie);
//            $entityManager->flush($inscriptionSortie);
//            $this->addFlash('ok','Vous êtes inscrit.');
//            return $this->redirectToRoute('app_inscription_sortie', [
//                'sortie' => $sortie]
//            );
//        }
//
//
//
//
//
//
//















        return $this->render('inscription/inscription_sortie.html.twig',[
            'inscriptionSortieForm' => $form->createView(),
        ]);
    }
}
