<?php

namespace App\Controller;

use App\Entity\FichesPostes;
use App\Repository\BriquesContexteRepository;
use App\Repository\EmploiRepository;
use App\Repository\FichesCompetencesRepository;
use App\Repository\FichesPostesRepository;
use App\Repository\RomeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/fiches/postes")
 */
class FichesPostesController extends AbstractController
{
    /**
     * @Route("/", name="app_fiches_postes_index", methods={"GET"})
     */
    public function index(FichesPostesRepository $fichesPostesRepository, RomeRepository $romeRepository, FichesCompetencesRepository $fichesCompetencesRepository): JsonResponse
    {
        $donnees = $fichesPostesRepository->findBy(["fiches_postes_entreprise"=> NULL]);
        $data["postelist"] = [];
        foreach ($donnees as $post) {
            $data["postelist"][] = $post->_getListPostData();
        }
        $allRomes = $romeRepository->findAll();
        $data["rome"] = [];
        foreach ($allRomes as $rome) {
            $data["rome"][] = $rome->_toArray();
        }
        $competance = $fichesCompetencesRepository->findBy(["entreprise"=> NULL]);
        $data["competance"] = [];
        foreach ($competance as $comp) {
            $data["competance"][] = $comp->_getListCompetance();
        }
        return new JsonResponse($data);
    }

    /**
     * @Route("/metier", name="app_fiches_postes_metier", methods={"GET"})
     */
    public function metier(FichesPostesRepository $fichesPostesRepository, RomeRepository $romeRepository, FichesCompetencesRepository $fichesCompetencesRepository): JsonResponse
    {
        $donnees = $fichesPostesRepository->findBy(["fiches_postes_entreprise"=> NULL]);
        $data["postelist"] = [];
        foreach ($donnees as $post) {
            $data["postelist"][] = $post->_getListPostData();
        }
        $allRomes = $romeRepository->findAll();
        $data["rome"] = [];
        foreach ($allRomes as $rome) {
            $data["rome"][] = $rome->_toArray();
        }
        $competance = $fichesCompetencesRepository->findBy(["entreprise"=> NULL]);
        $data["competance"] = [];
        foreach ($competance as $comp) {
            $data["competance"][] = $comp->_getListCompetance();
        }
        return new JsonResponse($data);
    }

    /**
     * @Route("/new", name="app_fiches_postes_new", methods={"GET", "POST"})
     */
    public function new(Request $request, FichesPostesRepository $fichesPostesRepository, RomeRepository $romeRepository, FichesCompetencesRepository $fichesCompetencesRepository): Response
    {
        $fichesPoste = new FichesPostes();
        $competance = $fichesCompetencesRepository->find((int)$request->request->get("competanceid"));
        $rome = $romeRepository->find((int)$request->request->get("metierid"));
        $fichesPoste->setConditionsGenerales($request->request->get("condition_general"));
        $fichesPoste->setFichesPostesAgrement($request->request->get("agrement"));
        $fichesPoste->setFichesPostesDefinition([$request->request->get("definition")]);
        $fichesPoste->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
        $fichesPoste->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
        $fichesPoste->setFichesPostesFicheRome($rome);
        $fichesPoste->setFichesPostesActivite([$request->request->get("activite")]);
        $fichesPoste->setInstructions([$request->request->get("instruction")]);
        $fichesPoste->setFichesPostesFicheCompetence($competance);
        $fichesPoste->setFichesPostesVersion((float)$request->request->get("version"));
        $fichesPoste->setFichesPostesTitre($request->request->get("titre"));
        $date = date("Y-m-d");
        $fichesPoste->setFichesPostesVisaAt(new \DateTime($date));
        $fichesPoste->setFichesPostesValidationAt(new \DateTime($date));
        $fichesPostesRepository->add($fichesPoste);
        $donnees = $fichesPostesRepository->findBy(["fiches_postes_entreprise"=> NULL]);
        $data["postelist"] = [];
        foreach ($donnees as $post) {
            $data["postelist"][] = $post->_getListPostData();
        }
        return new JsonResponse($data);
    }

    /**
     * @Route("/detail", name="app_poste_rome_detail", methods={"POST"})
     */
    public function detail( Request $request, RomeRepository $romeRepository, EmploiRepository $emploiRepository, BriquesContexteRepository $briquesContexteRepository, FichesCompetencesRepository $fichesCompetencesRepository ): JsonResponse
    {
        $rome = $romeRepository->findBy(["rome_coderome"=> $request->request->get("code")]);
        $data["rome"] = $rome[0]->_toArray();
        $data["appelation"] = $emploiRepository->findBy(["rome"=> $rome[0]]);
        $data["briquecompetance"] = [];
        foreach ($data["appelation"] as $key) {
            $datass = $fichesCompetencesRepository->findBy(["appelation"=> $key]);
            if (!empty($datass)) {
                $data["briquecompetance"][] = $datass[0];
            }
        }
        $data["briquecontexte"] = $briquesContexteRepository->findBy(["rome"=> $rome[0]]);
        return $this->json($data);
    }
}
