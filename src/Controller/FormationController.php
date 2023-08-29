<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/formation")
 */
class FormationController extends AbstractController
{
    /**
     * @Route("/", name="app_formation_index", methods={"GET"})
     */
    public function index(FormationRepository $formationRepository): JsonResponse
    {
        return $this->json($formationRepository->findAll());
    }

    /**
     * @Route("/new", name="app_formation_new", methods={"GET", "POST"})
     */
    public function new(Request $request, FormationRepository $formationRepository): JsonResponse
    {
        $formation = new Formation();
        $formation->setNom($request->request->get("nom"));
        $formation->setCategorie($request->request->get("categorie"));
        $formation->setGenre($request->request->get("genre"));
        $formation->setType($request->request->get("type"));
        $formation->setTarif((int)$request->request->get("tarif"));
        $formation->setDurrer((int)$request->request->get("durrer"));
        $formation->setProprietaire("Testeur");
        $formation->setCreation(new \DateTime('@'.strtotime('now')));
        $formationRepository->add($formation);
        return $this->json($formationRepository->findAll());
    }

    /**
     * @Route("/{id}/edit", name="app_formation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Formation $formation, FormationRepository $formationRepository): JsonResponse
    {
        $formation->setNom($request->request->get("nom"));
        $formation->setCategorie($request->request->get("categorie"));
        $formation->setGenre($request->request->get("genre"));
        $formation->setType($request->request->get("type"));
        $formation->setTarif((int)$request->request->get("tarif"));
        $formation->setDurrer((int)$request->request->get("durrer"));
        $formationRepository->add($formation);
        return $this->json($formationRepository->findAll());
    }

    /**
     * @Route("/{id}", name="app_formation_delete", methods={"POST"})
     */
    public function delete(Formation $formation, FormationRepository $formationRepository): JsonResponse
    {
        $formationRepository->remove($formation);
        return $this->json($formationRepository->findAll());
    }
}
