<?php

namespace App\Controller;

use App\Entity\PropositionPoste;
use App\Repository\PropositionPosteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/proposition/poste")
 */
class PropositionPosteController extends AbstractController
{
    /**
     * @Route("/", name="app_proposition_poste_index", methods={"GET"})
     */
    public function index(PropositionPosteRepository $propositionPosteRepository): JsonResponse
    {
        return $this->json($propositionPosteRepository->findAll());
    }

    /**
     * @Route("/new", name="app_proposition_poste_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PropositionPosteRepository $propositionPosteRepository): JsonResponse
    {
        $propositionPoste = new PropositionPoste();
        $propositionPosteRepository->add($propositionPoste);
        return $this->json($propositionPosteRepository->findAll());
    }

    /**
     * @Route("/{id}/edit", name="app_proposition_poste_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, PropositionPoste $propositionPoste, PropositionPosteRepository $propositionPosteRepository): JsonResponse
    {
        $propositionPosteRepository->add($propositionPoste);
        return $this->json($propositionPosteRepository->findAll());
    }

    /**
     * @Route("/{id}", name="app_proposition_poste_delete", methods={"POST"})
     */
    public function delete(Request $request, PropositionPoste $propositionPoste, PropositionPosteRepository $propositionPosteRepository): JsonResponse
    {
        $propositionPosteRepository->remove($propositionPoste);
        return $this->json($propositionPosteRepository->findAll());
    }
}
