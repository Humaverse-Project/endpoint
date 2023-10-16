<?php

namespace App\Controller;

use App\Entity\FichesPostes;
use App\Entity\Organigramme;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\FichesPostesRepository;
use App\Repository\PersonneRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\FichesCompetencesRepository;
use App\Repository\RomeRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\OrganigrammeRepository;

class OrganigrammeController extends AbstractController
{
    /**
     * @Route("/organigramme", name="app_organigramme", methods={"POST"})
     */
    public function index(Request $request, EntrepriseRepository $entrepriseRepository, FichesPostesRepository $fichesPostesRepository, PersonneRepository $personneRepository): JsonResponse
    {
        $entreprise = $entrepriseRepository->find((int)$request->request->get("entrepriseid"));
        $data["personnelist"] = [];
        $personnelist = $personneRepository->findBy(["entreprise"=> $entreprise]);
        foreach ($personnelist as $key) {
            $data["personnelist"][] = $key->_getOrganigrammeData();
        }
        $data["organigramme"] = $entreprise->getOrganigrammes();
        return $this->json($data);
    }
    /**
     * @Route("/organigramme/enregistrement", name="app_organigramme_enregistrement", methods={"POST"})
     */
    public function enregistrement(Request $request, EntrepriseRepository $entrepriseRepository, FichesPostesRepository $fichesPostesRepository, PersonneRepository $personneRepository, OrganigrammeRepository $organigrammeRepository): JsonResponse
    {
        $entreprise = $entrepriseRepository->find((int)$request->request->get("entrepriseid"));
        $ficheposte = $fichesPostesRepository->find((int)$request->request->get("posteid"));
        $organnigrame = new Organigramme();
        if ($request->request->get("parentNodeId") != "") {
            $organi1 = $organigrammeRepository->find((int)$request->request->get("parentNodeId"));
            $organnigrame->setOrganigrammeNplus1($organi1);
        }
        $organnigrame->setOrgIntitulePoste($request->request->get("titre"));
        $organnigrame->setFichesPostes($ficheposte);
        $organnigrame->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
        $organnigrame->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
        $organnigrame->setEntreprise($entreprise);
        if ($request->request->get("personneid") != "") {
            $personne = $personneRepository->find((int)$request->request->get("personneid"));
            $organnigrame->setPersonnes($personne);
        }
        $organigrammeRepository->add($organnigrame);
        if ($request->request->get("personneid") != NULL) {
            $personne = $personneRepository->find((int)$request->request->get("personneid"));
            $personne->setPersonnePoste($ficheposte);
            $personne->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
            $personneRepository->add($personne);
        }
        return $this->json($organnigrame);
    }
    /**
     * @Route("/organigramme/loadposte", name="app_organigramme_loadposte", methods={"POST"})
     */
    public function loadposte(Request $request, FichesPostesRepository $fichesPostesRepository, RomeRepository $romeRepository): JsonResponse
    {
        $rome = $romeRepository->findBy(["rome_coderome"=> $request->request->get("code")]);
        $listpost = $fichesPostesRepository->findBy(["fiches_postes_entreprise"=> null, "fiches_postes_fiche_rome"=> $rome[0]]);
        $data["poste_generique"] = [];
        foreach ($listpost as $key) {
            $data["poste_generique"][] = $key->_getListPostData();
        }
        return $this->json($data);
    }
    /**
     * @Route("/organigramme/postupdate", name="app_organigramme_postupdate", methods={"POST"})
     */
    public function postupdate(Request $request, OrganigrammeRepository $organigrammeRepository): JsonResponse{
        $ficheposte = $organigrammeRepository->find((int)$request->request->get("nodeId"));
        $fichepostnplusun = $organigrammeRepository->find((int)$request->request->get("parentNodeId"));
        $ficheposte->setOrganigrammeNplus1($fichepostnplusun);
        $organigrammeRepository->add($ficheposte);
        $data["stat"]= true;
        return $this->json($data);
    }

    /**
     * @Route("/organigramme/filtreficheposte", name="app_organigramme_filtreficheposte", methods={"POST"})
     */
    public function filtreficheposte(Request $request, FichesPostesRepository $fichesPostesRepository): JsonResponse
    {
        $poste = $fichesPostesRepository->fitrefichesposte($request->request->get("input"), $request->request->get("entrepriseid"));
        $data = [];
        foreach ($poste as $key) {
            $data[] = $key->_ogrannigrammeAjout();
        }
        return $this->json($data);
    }

    /**
     * @Route("/organigramme/delete/{id}", name="app_fiches_competences_delete", methods={"POST"})
     */
    public function delete(Request $request, Organigramme $organigramme, OrganigrammeRepository $organigrammeRepository, EntrepriseRepository $entrepriseRepository): JsonResponse
    {
        // $niveauexistlist = $organigrammeRepository->findBy(["organigramme_nplus_1"=> $organigramme]);
        // foreach ($niveauexistlist as $key) {
        //     $organigrammeRepository->remove($key);
        // }
        $organigrammeRepository->remove($organigramme);
        $entreprise = $entrepriseRepository->find((int)$request->request->get("entrepriseid"));
        $data["organigramme"] = $entreprise->getOrganigrammes();
        return $this->json($data);
    }
}
