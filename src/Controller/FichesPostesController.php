<?php

namespace App\Controller;

use App\Entity\BriquesContexteMetiers;
use App\Entity\ContextesTravail;
use App\Entity\FichesPostes;
use App\Repository\BriquesCompetencesRepository;
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
use App\Repository\ContextesTravailRepository;
use App\Repository\BriquesContexteMetiersRepository;
use App\Repository\OrganigrammeRepository;

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
        return $this->json($data);
    }

    /**
     * @Route("/new", name="app_fiches_postes_new", methods={"GET", "POST"})
     */
    public function new(Request $request, FichesPostesRepository $fichesPostesRepository, RomeRepository $romeRepository, FichesCompetencesRepository $fichesCompetencesRepository): Response
    {
        $fichesPoste = new FichesPostes();
        $competance = $fichesCompetencesRepository->find((int)$request->request->get("competanceid"));
        $rome = $romeRepository->find((int)$request->request->get("metierid"));
        $fichesPoste->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
        $fichesPoste->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
        $fichesPoste->setFichesPostesFicheRome($rome);
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
    public function detail( Request $request, RomeRepository $romeRepository, EmploiRepository $emploiRepository, BriquesContexteRepository $briquesContexteRepository, FichesCompetencesRepository $fichesCompetencesRepository, BriquesCompetencesRepository $briquesCompetencesRepository ): JsonResponse
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
        $data["briquecompetancerome"] = $briquesCompetencesRepository->findBy(["rome"=> $rome[0]]);
        $data["briquecontexte"] = $briquesContexteRepository->findBy(["rome"=> $rome[0]]);
        return $this->json($data);
    }

    /**
     * @Route("/newbo", name="app_fiches_postes_newbo", methods={"GET", "POST"})
     */
    public function newbo(Request $request, FichesPostesRepository $fichesPostesRepository, RomeRepository $romeRepository, FichesCompetencesRepository $fichesCompetencesRepository, ContextesTravailRepository $contextesTravailRepository, BriquesContexteMetiersRepository $briquesContexteMetiersRepository, EmploiRepository $emploiRepository): JsonResponse
    {
        $actuel = $fichesPostesRepository->find((int)$request->request->get("metierid"));
        $appelation = $emploiRepository->find((int)$request->request->get("emploisid"));
        $version = 1.0;
        if ($actuel !== null) {
            $version = (float)$actuel->getFichesPostesVersion()+0.1;
            $fichesPoste = $actuel;
        } else {
            $fichesPoste = new FichesPostes();
            $fichesPoste->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
        }
        $competance = $fichesCompetencesRepository->find((int)$request->request->get("competanceid"));
        $rome = $romeRepository->find((int)$request->request->get("romeid"));
        $fichesPoste->setFichesPostesVersion($version);
        $fichesPoste->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
        $fichesPoste->setFichesPostesFicheRome($rome);
        $fichesPoste->setAppelation($appelation);
        $fichesPoste->setFichesPostesFicheCompetence($competance);
        $fichesPoste->setFichesPostesTitre($request->request->get("titre"));
        $date = date("Y-m-d");
        $fichesPoste->setFichesPostesVisaAt(new \DateTime($date));
        $fichesPoste->setFichesPostesValidationAt(new \DateTime($date));
        $fichesPoste->setFichesPosteDefinition($request->request->get("definition"));
        $fichesPoste->setFichesPostesActivite($request->request->get("activite"));
        $fichesPoste->setFichesPostesConvention($request->request->get("convention"));
        $fichesPoste->setFichesPostFormations($request->request->get("formation"));
        $fichesPostesRepository->add($fichesPoste);
        $niveauexistlist = $briquesContexteMetiersRepository->findBy(["fichesPostes"=> $fichesPoste]);
        foreach ($niveauexistlist as $key) {
            $briquesContexteMetiersRepository->remove($key);
        }
        $agrementlist = $request->request->all("agrement");
        $agrementid = $request->request->all("agrementid");
        $ficheslist = $request->request->all("ficheslist");
        $ficheslistid = $request->request->all("ficheslistid");
        $conditionlist = $request->request->all("conditionlist");
        $conditionlistid = $request->request->all("conditionlistid");
        for ($i=0; $i < count($agrementlist); $i++) { 
            $context = $contextesTravailRepository->findBy(["ctx_trv_titre"=> "Agrément - Réglementation du métier"]);
            if (!empty($context)) {
                $context = $context[0];
            } else {
                $context = new ContextesTravail();
                $context->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
                $context->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
                $context->setCtxTrvTitre("Agrément - Réglementation du métier");
                $contextesTravailRepository->add($context);
            }
            $agremment = $briquesContexteMetiersRepository->find((int)$agrementid[$i]);
            if ($agremment == null) {
                $agremment = new BriquesContexteMetiers();
                $agremment->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
            }
            $agremment->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
            $agremment->setBrqctxmetiertitre($agrementlist[$i]);
            $agremment->setContexte($context);
            $agremment->setFichesPostes($fichesPoste);
            $briquesContexteMetiersRepository->add($agremment);
        }
        for ($i=0; $i < count($ficheslistid); $i++) { 
            $context = $contextesTravailRepository->findBy(["ctx_trv_titre"=> "Conditions générales de travail"]);
            if (!empty($context)) {
                $context = $context[0];
            } else {
                $context = new ContextesTravail();
                $context->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
                $context->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
                $context->setCtxTrvTitre("Conditions générales de travail");
                $contextesTravailRepository->add($context);
            }
            $agremment = $briquesContexteMetiersRepository->find((int)$ficheslistid[$i]);
            if ($agremment == null) {
                $agremment = new BriquesContexteMetiers();
                $agremment->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
            }
            $agremment->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
            $agremment->setBrqctxmetiertitre($ficheslist[$i]);
            $agremment->setContexte($context);
            $agremment->setFichesPostes($fichesPoste);
            $briquesContexteMetiersRepository->add($agremment);
        }
        for ($i=0; $i < count($conditionlistid); $i++) { 
            $context = $contextesTravailRepository->findBy(["ctx_trv_titre"=> "Fiches - Instructions - Scripts à respecter"]);
            if (!empty($context)) {
                $context = $context[0];
            } else {
                $context = new ContextesTravail();
                $context->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
                $context->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
                $context->setCtxTrvTitre("Fiches - Instructions - Scripts à respecter");
                $contextesTravailRepository->add($context);
            }
            $agremment = $briquesContexteMetiersRepository->find((int)$conditionlistid[$i]);
            if ($agremment == null) {
                $agremment = new BriquesContexteMetiers();
                $agremment->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
            }
            $agremment->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
            $agremment->setBrqctxmetiertitre($conditionlist[$i]);
            $agremment->setContexte($context);
            $agremment->setFichesPostes($fichesPoste);
            $briquesContexteMetiersRepository->add($agremment);
        }
        $donnees = $fichesPostesRepository->findBy(["fiches_postes_entreprise"=> NULL]);
        $data["postelist"] = [];
        foreach ($donnees as $post) {
            $data["postelist"][] = $post->_getListPostData();
        }
        return $this->json($data);
    }

    /**
     * @Route("/delete/{id}", name="app_fiches_poste_delete", methods={"POST"})
     */
    public function delete(FichesPostes $fichesPoste, BriquesContexteMetiersRepository $briquesContexteMetiersRepository, FichesPostesRepository $fichesPostesRepository, OrganigrammeRepository $organigrammeRepository): JsonResponse
    {
        $niveauexistlist = $briquesContexteMetiersRepository->findBy(["fichesPostes"=> $fichesPoste]);
        foreach ($niveauexistlist as $key) {
            $briquesContexteMetiersRepository->remove($key);
        }
        $organigramme = $organigrammeRepository->findBy(["fiches_postes"=> $fichesPoste]);
        foreach ($organigramme as $key) {
            $key->setFichesPostes(null);
            $organigrammeRepository->add($key);
        }
        $fichesPostesRepository->remove($fichesPoste);
        $donnees = $fichesPostesRepository->findBy(["fiches_postes_entreprise"=> NULL]);
        $data["postelist"] = [];
        foreach ($donnees as $post) {
            $data["postelist"][] = $post->_getListPostData();
        }
        return $this->json($data);
    }
}
