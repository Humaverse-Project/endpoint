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
    public function synchrome(RomeRepository $romeRepository, RomeInterface $romeInterface, CompetencesGlobalesRepository $competencesGlobalesRepository, BriquesCompetencesRepository $briquesCompetencesRepository)
    {
        set_time_limit(1500);
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
                    "comp_gb_titre"=> $valeur["enjeu"]["libelle"],
                    "competancelist"=> $valeur["competences"]
                ];
            }, $data["groupesCompetencesMobilisees"]);
            $resultatssavoir = array_map(function($valeur) {
                return [
                    "comp_gb_categorie" => "SAVOIRS",
                    "comp_gb_titre"=> $valeur["categorieSavoirs"]["libelle"],
                    "competancelist"=> $valeur["savoirs"]
                ];
            }, $data["groupesSavoirs"]);
            $result = array_merge($resultats, $resultatssavoir);
            for ($i=0; $i < count($result); $i++) { 
                $key = $result[$i];
                $comptanceglobal = array_filter($listcompetanceglobal, function ($entiteRome) use ($key) {
                    return ($entiteRome->getCompGbCategorie() === $key["comp_gb_categorie"] and $entiteRome->getCompGbTitre() === $key["comp_gb_titre"]);
                });
                if (!empty($comptanceglobal)) {
                    rsort($comptanceglobal);
                    $listcompetance = $result[$i]["competancelist"];
                    for ($m=0; $m < count($listcompetance); $m++) {
                        $brique = new BriquesCompetences;
                        $brique->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
                        $brique->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
                        $brique->setRome($metier);
                        $brique->setCompGb($comptanceglobal[0]);
                        $brique->setBrqCompTitre($listcompetance[$m]["libelle"]);
                        $briquesCompetencesRepository->add($brique);
                    }
                }
            }
            //dd($briqtoinsertinsert);
            $i = $i+1;
        }
        dd($briquesCompetencesRepository->findAll());
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
