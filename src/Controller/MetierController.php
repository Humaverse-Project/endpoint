<?php

namespace App\Controller;

use App\Entity\Metier;
use App\Repository\MetierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/metier")
 */
class MetierController extends AbstractController
{
    /**
     * @Route("/", name="app_metier_index", methods={"GET"})
     */
    public function index(MetierRepository $metierRepository): JsonResponse
    {
        return $this->json($metierRepository->findAll());
    }

    /**
     * @Route("/new", name="app_metier_new", methods={"GET", "POST"})
     */
    public function new(Request $request, MetierRepository $metierRepository): JsonResponse
    {
        $metier = new Metier();
        $metier->setCode($request->request->get("code"));
        $metier->setNom($request->request->get("nom"));
        $metier->setDescriptionC($request->request->get("description_c"));
        $metier->setDescriptionL($request->request->get("description_l"));
        $metier->setCreation(new \DateTime('@'.strtotime('now')));
        $metierRepository->add($metier);
        return $this->json($metierRepository->findAll());
    }

    /**
     * @Route("/{id}/edit", name="app_metier_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Metier $metier, MetierRepository $metierRepository): JsonResponse
    {
        $metier->setCode($request->request->get("code"));
        $metier->setNom($request->request->get("nom"));
        $metier->setDescriptionC($request->request->get("description_c"));
        $metier->setDescriptionL($request->request->get("description_l"));
        $metierRepository->add($metier);
        return $this->json($metierRepository->findAll());
    }

    /**
     * @Route("/{id}", name="app_metier_delete", methods={"POST"})
     */
    public function delete(Request $request, Metier $metier, MetierRepository $metierRepository): JsonResponse
    {
        // if ($this->isCsrfTokenValid('delete'.$metier->getId(), $request->request->get('_token'))) {
            $metierRepository->remove($metier);
        //}

        return $this->json($metierRepository->findAll());
    }
}
