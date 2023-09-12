<?php

namespace App\Controller;

use App\Entity\BriquesCompetences;
use App\Form\BriquesCompetencesType;
use App\Repository\BriquesCompetencesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RomeRepository;
use App\Repository\CompetencesGlobalesRepository;
use App\Services\ApiRequest\RomeInterface;
use App\Services\Helpers\ArrayHelpers;
/**
 * @Route("/briques/competences")
 */
class BriquesCompetencesController extends AbstractController
{
    /**
     * @Route("/", name="app_briques_competences_index", methods={"GET"})
     */
    public function index(BriquesCompetencesRepository $briquesCompetencesRepository): Response
    {
        return $this->render('briques_competences/index.html.twig', [
            'briques_competences' => $briquesCompetencesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_briques_competences_new", methods={"GET", "POST"})
     */
    public function new(Request $request, BriquesCompetencesRepository $briquesCompetencesRepository): Response
    {
        $briquesCompetence = new BriquesCompetences();
        $form = $this->createForm(BriquesCompetencesType::class, $briquesCompetence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $briquesCompetencesRepository->add($briquesCompetence);
            return $this->redirectToRoute('app_briques_competences_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('briques_competences/new.html.twig', [
            'briques_competence' => $briquesCompetence,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/synchrome", name="app_briques_competences_synchrome", methods={"GET", "POST"})
     */
    public function synchrome(RomeRepository $romeRepository, RomeInterface $romeInterface, CompetencesGlobalesRepository $competencesGlobalesRepository, ArrayHelpers $arrayHelpers)
    {
        set_time_limit(500);
        $scope = "nomenclatureRome api_rome-fiches-metiersv1";
        $access = $romeInterface->authetification($scope);
        $romemetierlist = $romeRepository->findAll();
        $i = 0;
        $listcompetanceglobal = $competencesGlobalesRepository->findAll();
        foreach ($romemetierlist as $metier) {
            if ($i % 100 == 0) {
                $access = $romeInterface->authetification($scope);
            }
            sleep(1);
            $data = $romeInterface->getFicheMetierDatainformation($access["access_token"], $metier->getRomeCoderome());
            $resultats = array_map(function($valeur) {
                $type = [];
                for ($i=0; $i < count($valeur["competences"]); $i++) { 
                    $type[] = $valeur["competences"][$i]["type"];
                }
                if (in_array("MACRO-SAVOIR-ETRE-PROFESSIONNEL", $type) or in_array("MACRO-SAVOIR-ETRE", $type)) {
                    $typecomp = "SAVOIR ÊTRE";
                } else {
                    $typecomp = "SAVOIRS FAIRE";
                }
                return [
                    "comp_gb_categorie" => $typecomp,
                    "comp_gb_titre"=> $valeur["enjeu"]["libelle"]
                ];
            }, $data["groupesCompetencesMobilisees"]);
            $resultatssavoir = array_map(function($valeur) {
                return [
                    "comp_gb_categorie" => "SAVOIRS",
                    "comp_gb_titre"=> $valeur["categorieSavoirs"]["libelle"]
                ];
            }, $data["groupesSavoirs"]);
            $result = array_merge($resultats, $resultatssavoir);
            $result = $arrayHelpers->arrayunique($result);
            $competanceglbtoinsert = [];
            for ($i=0; $i < count($result); $i++) { 
                $key = $result[$i];
                $comptanceglobal = array_filter($listcompetanceglobal, function ($entiteRome) use ($key) {
                    return ($entiteRome->getCompGbCategorie() === $key["comp_gb_categorie"] and $entiteRome->getCompGbTitre() === $key["comp_gb_titre"]);
                });
                if (empty($comptanceglobal)) {
                    $competanceglbtoinsert[] = $key;
                }
            }
            $competencesGlobalesRepository->batchinsert($competanceglbtoinsert);
            $listcompetanceglobal = $competencesGlobalesRepository->findAll();
            $i = $i+1;
        }
    }

    /**
     * @Route("/{id}", name="app_briques_competences_show", methods={"GET"})
     */
    public function show(BriquesCompetences $briquesCompetence): Response
    {
        return $this->render('briques_competences/show.html.twig', [
            'briques_competence' => $briquesCompetence,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_briques_competences_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, BriquesCompetences $briquesCompetence, BriquesCompetencesRepository $briquesCompetencesRepository): Response
    {
        $form = $this->createForm(BriquesCompetencesType::class, $briquesCompetence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $briquesCompetencesRepository->add($briquesCompetence);
            return $this->redirectToRoute('app_briques_competences_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('briques_competences/edit.html.twig', [
            'briques_competence' => $briquesCompetence,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_briques_competences_delete", methods={"POST"})
     */
    public function delete(Request $request, BriquesCompetences $briquesCompetence, BriquesCompetencesRepository $briquesCompetencesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$briquesCompetence->getId(), $request->request->get('_token'))) {
            $briquesCompetencesRepository->remove($briquesCompetence);
        }

        return $this->redirectToRoute('app_briques_competences_index', [], Response::HTTP_SEE_OTHER);
    }
}
