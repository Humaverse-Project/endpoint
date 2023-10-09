<?php

namespace App\Controller;

use App\Repository\CompetencesGlobalesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/synchrome", name="app_competences_globales_synchrome", methods={"GET"})
     */
    public function synchrome(RomeRepository $romeRepository, RomeInterface $romeInterface, CompetencesGlobalesRepository $competencesGlobalesRepository, ArrayHelpers $arrayHelpers)
    {
        set_time_limit(500);
        ini_set('memory_limit', '2566M');
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
                for ($m=0; $m < count($result); $m++) { 
                    $key = $result[$m];
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
        dd("terminer");
    }
}
