<?php

namespace App\Controller;

use App\Entity\CompetencesGlobales;
use App\Form\CompetencesGlobalesType;
use App\Repository\CompetencesGlobalesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\ApiRequest\RomeInterface;
use App\Repository\RomeRepository;
use App\Services\Helpers\ArrayHelpers;

/**
 * @Route("/competences/globales")
 */
class CompetencesGlobalesController extends AbstractController
{
    /**
     * @Route("/", name="app_competences_globales_index", methods={"GET"})
     */
    public function index(CompetencesGlobalesRepository $competencesGlobalesRepository): Response
    {
        return $this->render('competences_globales/index.html.twig', [
            'competences_globales' => $competencesGlobalesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_competences_globales_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CompetencesGlobalesRepository $competencesGlobalesRepository): Response
    {
        $competencesGlobale = new CompetencesGlobales();
        $form = $this->createForm(CompetencesGlobalesType::class, $competencesGlobale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $competencesGlobalesRepository->add($competencesGlobale);
            return $this->redirectToRoute('app_competences_globales_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('competences_globales/new.html.twig', [
            'competences_globale' => $competencesGlobale,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/synchrome", name="app_competences_globales_synchrome", methods={"GET"})
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
     * @Route("/{id}", name="app_competences_globales_show", methods={"GET"})
     */
    public function show(CompetencesGlobales $competencesGlobale): Response
    {
        return $this->render('competences_globales/show.html.twig', [
            'competences_globale' => $competencesGlobale,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_competences_globales_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CompetencesGlobales $competencesGlobale, CompetencesGlobalesRepository $competencesGlobalesRepository): Response
    {
        $form = $this->createForm(CompetencesGlobalesType::class, $competencesGlobale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $competencesGlobalesRepository->add($competencesGlobale);
            return $this->redirectToRoute('app_competences_globales_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('competences_globales/edit.html.twig', [
            'competences_globale' => $competencesGlobale,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_competences_globales_delete", methods={"POST"})
     */
    public function delete(Request $request, CompetencesGlobales $competencesGlobale, CompetencesGlobalesRepository $competencesGlobalesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$competencesGlobale->getId(), $request->request->get('_token'))) {
            $competencesGlobalesRepository->remove($competencesGlobale);
        }

        return $this->redirectToRoute('app_competences_globales_index', [], Response::HTTP_SEE_OTHER);
    }
}
