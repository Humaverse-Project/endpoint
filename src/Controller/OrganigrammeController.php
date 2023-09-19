<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\FichesPostesRepository;
use App\Repository\PersonneRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\FichesCompetencesRepository;
use App\Repository\RomeRepository;
use App\Entity\FichesPostes;
use App\Entity\Personne;
use Symfony\Component\HttpFoundation\JsonResponse;

class OrganigrammeController extends AbstractController
{
    /**
     * @Route("/organigramme", name="app_organigramme", methods={"POST"})
     */
    public function index(Request $request, EntrepriseRepository $entrepriseRepository, FichesPostesRepository $fichesPostesRepository, FichesCompetencesRepository $fichesCompetencesRepository, RomeRepository $romeRepository): JsonResponse
    {
        $entreprise = $entrepriseRepository->find((int)$request->request->get("entrepriseid"));
        $data["personnelist"] = $entreprise->getPersonnes();
        $data["poste"] = $fichesPostesRepository->findBy(["fiches_postes_entreprise"=> $entreprise]);
        $allRomes = $romeRepository->findAll();
        $formattedData = [];
        foreach ($allRomes as $rome) {
            $formattedData[] = $rome->_toArray();
        }
        $data["rome"] = $formattedData;
        $data["competance"] = $fichesCompetencesRepository->findAll();
        return $this->json($data);
    }
}
