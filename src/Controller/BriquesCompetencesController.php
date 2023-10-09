<?php

namespace App\Controller;

use App\Entity\BriquesCompetences;
use App\Entity\CompetencesGlobales;
use App\Repository\BriquesCompetencesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\RomeRepository;
use App\Repository\CompetencesGlobalesRepository;
use App\Services\ApiRequest\RomeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/briques/competences")
 */
class BriquesCompetencesController extends AbstractController
{
    /**
     * @Route("/synchrome", name="app_briques_competences_synchrome", methods={"GET", "POST"})
     */
    public function synchrome(RomeRepository $romeRepository, RomeInterface $romeInterface, CompetencesGlobalesRepository $competencesGlobalesRepository, BriquesCompetencesRepository $briquesCompetencesRepository)
    {
        set_time_limit(1500);
        ini_set('memory_limit', '2566M');
        $scope = "nomenclatureRome api_rome-fiches-metiersv1";
        $access = $romeInterface->authetification($scope);
        $romemetierlist = $romeRepository->findAll();
        $iss = 0;
        $listcompetanceglobal = $competencesGlobalesRepository->findAll();
        foreach ($romemetierlist as $metier) {
            if ($iss % 100 == 0) {
                $access = $romeInterface->authetification($scope);
            }
            sleep(1);
            $data = $romeInterface->getFicheMetierDatainformation($access["access_token"], $metier->getRomeCoderome());
            if (!empty($data)) {
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
                $comrome = $briquesCompetencesRepository->findBy(["rome"=> $metier]);
                $datalist = [];
                for ($m=0; $m < count($result); $m++) {
                    $datasssss = $result[$m]["competancelist"];
                    for ($s=0; $s < count($datasssss); $s++) { 
                        $datalist[]= ["libel" => $datasssss[$s]["libelle"], "comp_gb_titre"=> $result[$m]["comp_gb_titre"], "comp_gb_categorie"=> $result[$m]["comp_gb_categorie"]];
                    }
                }
                
                if (count($comrome) == count($datalist)) continue;
                if ((count($comrome) > count($datalist)) or (count($comrome) < count($datalist))) {
                    foreach ($comrome as $key) {
                        $briquesCompetencesRepository->remove($key);
                    }
                }
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
                    } else {
                        $comptanceglobal = new CompetencesGlobales();
                        $comptanceglobal->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
                        $comptanceglobal->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
                        $comptanceglobal->setCompGbCategorie($key["comp_gb_categorie"]);
                        $comptanceglobal->setCompGbTitre($key["comp_gb_titre"]);
                        $competencesGlobalesRepository->add($comptanceglobal);
                        $listcompetanceglobal = $competencesGlobalesRepository->findAll();
                        for ($ss=0; $ss < count($key["competancelist"]); $ss++) { 
                            $brique = new BriquesCompetences;
                            $brique->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
                            $brique->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
                            $brique->setRome($metier);
                            $brique->setCompGb($comptanceglobal);
                            $brique->setBrqCompTitre($key["competancelist"][$ss]["libelle"]);
                            $briquesCompetencesRepository->add($brique);
                        }
                    }
                }
                $iss = $iss+1;
            }
        }
        dd($briquesCompetencesRepository->findAll());
    }
    /**
     * @Route("/load", name="app_competences_globales_load", methods={"POST"})
     */
    public function load(Request $request,BriquesCompetencesRepository $briquesCompetencesRepository, CompetencesGlobalesRepository $competencesGlobalesRepository): JsonResponse
    {
        $competance = $competencesGlobalesRepository->find((int)$request->request->get("categorie_id"));
        return $this->json($briquesCompetencesRepository->findBy(["comp_gb"=>$competance]));
    }
}
