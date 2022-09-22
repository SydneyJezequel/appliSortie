<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Sortie;
use App\Form\FiltreType;
use App\Form\InscriptionSortieFormType;
use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionSortieController extends AbstractController
{
    /**
     * @Route("/inscription", name="app_inscription")
     */
    public function inscriptionSortie(Request $request): Response
    {
//        $user = $participant.$this->getUser();

//        $listeInscrits = $sortie->getInscrits();
//        dd($listeInscrits);
        $form = $this->createForm(InscriptionSortieFormType::class);
        $form->handleRequest($request);
        return $this->render('inscription/inscription_sortie.html.twig',[
            'inscriptionForm' => $form->createView(),
        ]);
    }
}
