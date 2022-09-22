<?php

namespace App\Controller\Api;

use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/apiSorties", name="api_sorties")
 */
class ApiSorties extends AbstractController
{
    /**
     * @Route("/sorties", name="sorties", methods={"GET"})
     */
    public function listeSorties(SortieRepository $sortieRepository): JsonResponse
    {
        $sorties= $sortieRepository->findAll();
        return $this->json($sorties, Response::HTTP_OK,[],['groups'=>'liste_sorties']);
    }

}
