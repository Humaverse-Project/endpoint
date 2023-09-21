<?php

namespace App\Controller;

use App\Entity\FichesPostes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\FichesPostesRepository;
use App\Repository\PersonneRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\FichesCompetencesRepository;
use App\Repository\RomeRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

class OrganigrammeController extends AbstractController
{
    /**
     * @Route("/organigramme", name="app_organigramme", methods={"POST"})
     */
    public function index(Request $request, EntrepriseRepository $entrepriseRepository, FichesPostesRepository $fichesPostesRepository, FichesCompetencesRepository $fichesCompetencesRepository, RomeRepository $romeRepository, PersonneRepository $personneRepository): JsonResponse
    {
        $entreprise = $entrepriseRepository->find((int)$request->request->get("entrepriseid"));
        $data["personnelist"] = [];
        $personnelist = $personneRepository->findBy(["entreprise"=> $entreprise]);
        foreach ($personnelist as $key) {
            $data["personnelist"][] = $key->_getOrganigrammeData();
        }
        $listpost = $fichesPostesRepository->findBy(["fiches_postes_entreprise"=> $entreprise]);
        $data["poste"] = [];
        foreach ($listpost as $key) {
            $data["poste"][] = $key->_getOrganigrammeData();
        }
        $allRomes = $romeRepository->findAll();
        $data["rome"] = [];
        foreach ($allRomes as $rome) {
            $data["rome"][] = $rome->_toArray();
        }
        $competance = $fichesCompetencesRepository->findBy(["entreprise"=> NULL]);
        $competance2 = $fichesCompetencesRepository->findBy(["entreprise"=> $entreprise]);
        $data["competance"] = [];
        foreach ($competance as $comp) {
            $data["competance"][] = $comp->_getListCompetance();
        }
        foreach ($competance2 as $comp) {
            $data["competance"][] = $comp->_getListCompetance();
        }
        return $this->json($data);
    }
    /**
     * @Route("/organigramme/enregistrement", name="app_organigramme_enregistrement", methods={"POST"})
     */
    public function enregistrement(Request $request, EntrepriseRepository $entrepriseRepository, FichesPostesRepository $fichesPostesRepository, FichesCompetencesRepository $fichesCompetencesRepository, RomeRepository $romeRepository, PersonneRepository $personneRepository): JsonResponse
    {
        $entreprise = $entrepriseRepository->find((int)$request->request->get("entrepriseid"));
        $competance = $fichesCompetencesRepository->find((int)$request->request->get("competanceid"));
        $rome = $romeRepository->find((int)$request->request->get("metierid"));
        $ficheposte = new FichesPostes();
        if ($request->request->get("parentNodeId") != "") {
            $fichepostnplusun = $fichesPostesRepository->find((int)$request->request->get("parentNodeId"));
            $ficheposte->setFichesPostesNplus1($fichepostnplusun);
        }
        $ficheposte->setConditionsGenerales($request->request->get("condition_general"));
        $ficheposte->setFichesPostesAgrement($request->request->get("agrement"));
        $ficheposte->setFichesPostesDefinition([$request->request->get("definition")]);
        $ficheposte->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
        $ficheposte->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
        $ficheposte->setFichesPostesFicheRome($rome);
        $ficheposte->setFichesPostesActivite([$request->request->get("activite")]);
        $ficheposte->setInstructions([$request->request->get("instruction")]);
        $ficheposte->setFichesPostesEntreprise($entreprise);
        $ficheposte->setFichesPostesFicheCompetence($competance);
        $ficheposte->setFichesPostesTitre($request->request->get("titre"));
        $date = date("Y-m-d");
        $ficheposte->setFichesPostesVisaAt(new \DateTime($date));
        $ficheposte->setFichesPostesValidationAt(new \DateTime($date));
        $fichesPostesRepository->add($ficheposte);
        if ($request->request->get("personneid") != NULL) {
            $personne = $personneRepository->find((int)$request->request->get("personneid"));
            $personne->setPersonnePoste($ficheposte);
            $personne->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
            $personneRepository->add($personne);
        }
        $data["stat"]= true;
        return $this->json($ficheposte->_getOrganigrammeData());
    }
    /**
     * @Route("/organigramme/postupdate", name="app_organigramme_postupdate", methods={"POST"})
     */
    public function postupdate(Request $request, FichesPostesRepository $fichesPostesRepository): JsonResponse{
        $ficheposte = $fichesPostesRepository->find((int)$request->request->get("nodeId"));
        $fichepostnplusun = $fichesPostesRepository->find((int)$request->request->get("parentNodeId"));
        $ficheposte->setFichesPostesNplus1($fichepostnplusun);
        $fichesPostesRepository->add($ficheposte);
        $data["stat"]= true;
        return $this->json($data);
    }
}
