<?php

namespace App\Controller;

use App\Entity\ContextesTravail;
use App\Entity\BriquesContexte;
use App\Entity\Emploi;
use App\Repository\ContextesTravailRepository;
use App\Repository\BriquesContexteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\ApiRequest\RomeInterface;
use App\Repository\RomeRepository;
use App\Repository\EmploiRepository;
/**
 * @Route("/contextes/travail")
 */
class ContextesTravailController extends AbstractController
{
    /**
     * @Route("/synchrome", name="app_contextes_travail_synchrome", methods={"GET"})
     */
    public function synchrome(RomeRepository $romeRepository, RomeInterface $romeInterface, ContextesTravailRepository $contextesTravailRepository, BriquesContexteRepository $briquesContexteRepository, EmploiRepository $emploiRepository)
    {
        set_time_limit(500);
        ini_set('memory_limit', '2566M');
        $scope = "nomenclatureRome api_rome-metiersv1";
        $access = $romeInterface->authetification($scope);
        $romemetierlist = $romeRepository->findAll();
        $lli = 0;
        $contextesTravail = $contextesTravailRepository->findAll();
        foreach ($romemetierlist as $metier) {
            if ($lli % 100 == 0) {
                $access = $romeInterface->authetification($scope);
            }
            sleep(1);
            $data = $romeInterface->getFicheMetierMetierDatainformation($access["access_token"], $metier->getRomeCoderome());
            if (!empty($data)) {
                $resultats = array_map(function($valeur) {
                    $data = new ContextesTravail;
                    $data->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
                    $data->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
                    $data->setCtxTrvTitre($valeur["categorie"]);
                    return $data;
                }, $data["contextesTravail"]);
                $uniqueValues = [];
                $resultats = array_values(array_filter($resultats, function ($item) use (&$uniqueValues) {
                    if (!isset($uniqueValues[$item->getCtxTrvTitre()])) {
                        $uniqueValues[$item->getCtxTrvTitre()] = true;
                        return true;
                    }
                    return false;
                }));
                for ($i=0; $i < count($resultats); $i++) {
                    $key = $resultats[$i];
                    $contextr = array_filter($contextesTravail, function ($entiteRome) use ($key) {
                        return ($entiteRome->getCtxTrvTitre() === $key->getCtxTrvTitre());
                    });
                    if (empty($contextr)) {
                        $contextesTravailRepository->add($key);
                    }
                }
                $contextesTravail = $contextesTravailRepository->findAll();
                $resultatsbrique = array_map(function($valeur) use ($metier, $contextesTravail) {
                    $contextr = array_filter($contextesTravail, function ($entiteRome) use ($valeur) {
                        return ($entiteRome->getCtxTrvTitre() === $valeur["categorie"]);
                    });
                    $data = new BriquesContexte;
                    $data->setBrqCtxTitre($valeur["libelle"]);
                    $data->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
                    $data->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
                    $data->setRome($metier);
                    if (!empty($contextr)) {
                        rsort($contextr);
                        $data->setContexte($contextr[0]);
                    }
                    return $data;
                }, $data["contextesTravail"]);
                $briqcontext = $briquesContexteRepository->findBy(["rome"=> $metier]);
                if (count($briqcontext) == count($resultatsbrique)) continue;
                if ((count($briqcontext) > count($resultatsbrique)) or (count($briqcontext) < count($resultatsbrique))) {
                    foreach ($briqcontext as $key) {
                        $briquesContexteRepository->remove($key);
                    }
                }
                for ($k=0; $k < count($resultatsbrique); $k++) { 
                    $briquesContexteRepository->add($resultatsbrique[$k]);
                }
                $resultats = array_map(function($valeur) use ($metier) {
                    $data = new Emploi;
                    $data->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
                    $data->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
                    $data->setEmploiTitre($valeur["libelle"]);
                    $data->setRome($metier);
                    return $data;
                }, $data["appellations"]);
                $appelationdatabase = $emploiRepository->findBy(["rome"=> $metier]);
                if (count($appelationdatabase) == count($resultats)) continue;
                if ((count($appelationdatabase) > count($resultats)) or (count($appelationdatabase) < count($resultats))) {
                    foreach ($appelationdatabase as $key) {
                        $emploiRepository->remove($key);
                    }
                }
                for ($k=0; $k < count($resultats); $k++) { 
                    $emploiRepository->add($resultats[$k]);
                }
                
                $lli = $lli+1;
            }
        }
        dd("terminer");
    }
}
