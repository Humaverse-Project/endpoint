<?php

namespace App\Controller;

use App\Entity\Competance;
use App\Repository\CompetanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * @Route("/competance")
 */
class CompetanceController extends AbstractController
{
    /**
     * @Route("/", name="app_competance_index", methods={"GET"})
     */
    public function index(CompetanceRepository $competanceRepository): JsonResponse
    {
        return $this->json($competanceRepository->findAll());
    }

    /**
     * @Route("/new", name="app_competance_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CompetanceRepository $competanceRepository): JsonResponse
    {
        $competance = new Competance();
        
        $competanceRepository->add($competance);
        return $this->json($competanceRepository->findAll());
    }

    /**
     * @Route("/{id}", name="app_competance_show", methods={"GET"})
     */
    public function show(Competance $competance): JsonResponse
    {
        return $this->json($competanceRepository->findAll());
    }

    /**
     * @Route("/{id}/edit", name="app_competance_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Competance $competance, CompetanceRepository $competanceRepository): JsonResponse
    {
        $competanceRepository->add($competance);
        return $this->json($competanceRepository->findAll());
    }

    /**
     * @Route("/{id}", name="app_competance_delete", methods={"POST"})
     */
    public function delete(Request $request, Competance $competance, CompetanceRepository $competanceRepository): JsonResponse
    {
        $competanceRepository->remove($competance);
        return $this->json($competanceRepository->findAll());
    }
}
