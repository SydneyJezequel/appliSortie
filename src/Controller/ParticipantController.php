<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ModifierParticipantType;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParticipantController extends AbstractController
{


    /**
     * @Route("/afficherProfil/{id}", name="afficher_profil", methods={"GET"})
     */
    public function AfficherProfil(Participant $participant, ParticipantRepository $participantRepository): Response
    {
        $id = $participant->getId();
        $participant = $participantRepository->find($id);
        return $this->render(
            'home/afficherProfil.html.twig', [
            'user' => $participant,
        ]);
    }


    /**
     * @Route("/modifierProfil/{id}", name="modifier_user", methods={"GET","POST"})
     */
    public function modifierParticipant(Participant $participant, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(ModifierParticipantType::class, $participant);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
            $this->addFlash(
                'ok',
                'L\'utilisateur a été modifiée.'
            );
            return $this->redirectToRoute('afficher_profil', ['id'=>$participant->getId()]);
        }
        return $this->render(
            'home/modifierProfil.html.twig', [
            'formulaire' => $form->createView(),
            'user' => $participant,
        ]);
    }

}
