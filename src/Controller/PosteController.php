<?php

namespace App\Controller;

use App\Entity\Poste;
use App\Form\PosteType;
use App\Repository\PosteRepository;
use App\Repository\CompetanceRepository;
use App\Repository\MetierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/poste")
 */
class PosteController extends AbstractController
{
    /**
     * @Route("/", name="app_poste_index", methods={"GET"})
     */
    public function index(PosteRepository $posteRepository): JsonResponse
    {
        return $this->json($posteRepository->findAll());
    }

    /**
     * @Route("/new", name="app_poste_new", methods={"GET", "POST"})
     */
    public function new(
        Request $request,
        PosteRepository $posteRepository,
        CompetanceRepository $competanceRepository,
        MetierRepository $metierRepository
    ): JsonResponse {
        $poste = new Poste();
        $competance = $competanceRepository->find((int)$request->request->get("competance_id"));
        $poste->setCompetance($competance);
        $metier = $metierRepository->find((int)$request->request->get("metier_id"));
        $poste->setMetier($metier);
        $poste->setCreation(new \DateTime('@'.strtotime('now')));
        $poste->setNiveauCompetance($request->request->get("niveau_competance"));
        $posteRepository->add($poste);
        return $this->json($poste);
    }

    /**
     * @Route("/test", name="app_poste_test", methods={"GET", "POST"})
     */
    public function test(
        Request $request,
        CompetanceRepository $competanceRepository
    ): JsonResponse {
        dd($competanceRepository->find($request->query->get("competance_id")));
        return $this->json($competanceRepository->find($request->query->get("competance_id")));
    }

    /**
     * @Route("/{id}/edit", name="app_poste_edit", methods={"GET", "POST"})
     */
    public function edit(
        Request $request,
        Poste $poste,
        PosteRepository $posteRepository,
        CompetanceRepository $competanceRepository,
        MetierRepository $metierRepository
    ): JsonResponse
    {
        $competance = $competanceRepository->find((int)$request->request->get("competance_id"));
        $poste->setCompetance($competance);
        $metier = $metierRepository->find((int)$request->request->get("metier_id"));
        $poste->setMetier($metier);
        $poste->setNiveauCompetance($request->request->get("niveau_competance"));
        $posteRepository->add($poste);
        return $this->json($posteRepository->findAll());
    }

    /**
     * @Route("/GetListByCompetanceID/{id}", name="app_poste_get_by_competance_id", methods={"GET"})
     */
    public function GetListByCompetanceID(PosteRepository $posteRepository, CompetanceRepository $competanceRepository, int $id) : JsonResponse {
        $competance = $competanceRepository->find($id);
        $data = $posteRepository->findBy(["competance"=>$competance]);
        return $this->json($data);
    }

    /**
     * @Route("/GetListByMetierID/{id}", name="app_poste_get_by_metier_id", methods={"GET"})
     */
    public function GetListByMetierID(PosteRepository $posteRepository, MetierRepository $metierRepository,int $id) : JsonResponse {
        $metier = $metierRepository->find($id);
        $data = $posteRepository->findBy(["metier"=>$metier]);
        return $this->json($data);
    }

    /**
     * @Route("/{id}", name="app_poste_delete", methods={"POST"})
     */
    public function delete(Request $request, Poste $poste, PosteRepository $posteRepository): JsonResponse
    {
        $posteRepository->remove($poste);
        return $this->json($posteRepository->findAll());
    }
}
