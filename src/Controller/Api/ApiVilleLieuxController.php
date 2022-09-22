<?php

namespace App\Controller\Api;

use App\Entity\Ville;
use App\Repository\LieuRepository;
use App\Repository\VilleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api")
 */
class ApiVilleLieuxController extends AbstractController
{
    /**
     * @Route("/villes", name="app_api_ville_lieux", methods={"GET"})
     */
    public function listeVilles(VilleRepository $villeRepository): JsonResponse
    {
        $villes = $villeRepository->findAll();
        return $this->json($villes, Response::HTTP_OK,[],['groups'=>'liste_villes']);
    }


    /**
     * @Route("/lieux/{id}", name="lieux_villes", methods={"GET"})
     */

    public function listeLieux(Ville $ville, LieuRepository $lieuRepository ): JsonResponse
    {
        $lieux= $lieuRepository->findBy(['ville' => $ville]);
        return $this->json($lieux, Response::HTTP_OK,[],['groups'=>'liste_lieux']);
    }



}
