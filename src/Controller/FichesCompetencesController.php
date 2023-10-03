<?php

namespace App\Controller;

use App\Entity\FichesCompetences;
use App\Entity\Accreditation;
use App\Entity\BriquesCompetences;
use App\Entity\BriquesCompetencesNiveau;
use App\Entity\CompetencesGlobales;
use App\Form\FichesCompetencesType;
use App\Repository\FichesCompetencesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\BriquesCompetencesNiveauRepository;
use App\Repository\CompetencesGlobalesRepository;
use App\Repository\BriquesCompetencesRepository;
use App\Repository\EmploiRepository;
use App\Repository\RomeRepository;

/**
 * @Route("/fiches/competences")
 */
class FichesCompetencesController extends AbstractController
{
    /**
     * @Route("/", name="app_fiches_competences_index", methods={"GET"})
     */
    public function index(FichesCompetencesRepository $fichesCompetencesRepository, RomeRepository $romeRepository, CompetencesGlobalesRepository $competencesGlobalesRepository): JsonResponse
    {
        $allRomes = $romeRepository->findAll();
        $data["rome"] = [];
        foreach ($allRomes as $rome) {
            $data["rome"][] = $rome->_toArray();
        }
        $data["fiche_competance"] = $fichesCompetencesRepository->findAll();
        $data["fiche_competance_global"] = $competencesGlobalesRepository->findAll();
        return $this->json($data);
    }

    /**
     * @Route("/new", name="app_fiches_competences_new", methods={"GET", "POST"})
     */
    public function new(Request $request, FichesCompetencesRepository $fichesCompetencesRepository, BriquesCompetencesRepository $briquesCompetencesRepository, BriquesCompetencesNiveauRepository $briquesCompetencesNiveau, RomeRepository $romeRepository, EmploiRepository $emploiRepository, CompetencesGlobalesRepository $competencesGlobalesRepository): JsonResponse
    {
        $appelationlist = [];
        if ($request->request->get("applicationall") == "ok") {
            $emploisdata = $emploiRepository->findBy(["rome"=> (int)$request->request->get("romeid")]);
            foreach ($emploisdata as $key) {
                $appelationlist[] = $key;
            }
        } else {
            $emplois = $emploiRepository->find((int)$request->request->get("emploisid"));
            $appelationlist[] = $emplois;
        }
        for ($kl=0; $kl < count($appelationlist); $kl++) { 
            $actuel = $fichesCompetencesRepository->findBy(["appelation"=>$appelationlist[$kl]], ['id' => 'DESC']);
            $version = 1.0;
            if (!empty($actuel)) {
                $actuel = $actuel[0];
                $version = (float)$actuel->getFicCompVersion()+0.1;
                $fichesCompetence = $actuel;
            } else {
                $fichesCompetence = new FichesCompetences();
                $fichesCompetence->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
            }
            $fichesCompetence->setFicCompVersion($version);
            $fichesCompetence->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
            $fichesCompetence->setFicCompTitreEmploi($appelationlist[$kl]->getEmploiTitre());
            
            $briquelist = $request->request->all("brique");
            $niveaulist = $request->request->all("niveau");
            $acreditationlist = $request->request->all("accreditationname");
            $accreditationvalue = $request->request->all("accreditationvalue");
            for ($i=0; $i < count($acreditationlist); $i++) { 
                $dataacc = $fichesCompetence->getAccreditation();
                $unacc = $acreditationlist[$i];
                $testacreditation = array_filter($dataacc->toArray(), function ($entiteAccreditation) use ($unacc) {
                    return ($entiteAccreditation->getAccreTitre() === $unacc);
                });
                if (count($testacreditation) == 0) {
                    $acreditation = new Accreditation();
                    $acreditation->setAccreTitre($acreditationlist[$i]);
                    $acreditation->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
                }
                else {
                    rsort($testacreditation);
                    $acreditation = $testacreditation[0];
                }
                $acreditation->setValue($accreditationvalue[$i]);
                $acreditation->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
                $fichesCompetence->addAccreditation($acreditation);
            }
            for ($i=0; $i < count($briquelist); $i++) { 
                $brique = $briquesCompetencesRepository->find($briquelist[$i]);
                $fichesCompetence->addFicCompCompetence($brique);
            }
            $globaltitrelist = $request->request->all("globaltitre");
            $globalidlist = $request->request->all("globalid");
            $compettitrelist = $request->request->all("compettitre");
            $globalcategorielist = $request->request->all("globalcategorie");
            $metier = $romeRepository->find((int)$request->request->get("romeid"));
            for ($i=0; $i < count($globaltitrelist); $i++) { 
                if ($globalidlist[$i] == "nouveau") {
                    $compglob = new CompetencesGlobales();
                    $compglob->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
                    $compglob->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
                    $compglob->setCompGbCategorie($globalcategorielist[$i]);
                    $compglob->setCompGbTitre($globaltitrelist[$i]);
                    $competencesGlobalesRepository->add($compglob);
                } else {
                    $compglob = $competencesGlobalesRepository->find((int)$globalidlist[$i]);
                }
                $brique = new BriquesCompetences();
                $brique->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
                $brique->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
                $brique->setRome($metier);
                $brique->setCompGb($compglob);
                $brique->setBrqCompTitre($compettitrelist[$i]);
                $briquesCompetencesRepository->add($brique);
                $fichesCompetence->addFicCompCompetence($brique);
            }
            $fichesCompetence->setAppelation($appelationlist[$kl]);
            $fichesCompetencesRepository->add($fichesCompetence);
            for ($i=0; $i < count($niveaulist); $i++) { 
                $brique = $briquesCompetencesRepository->find((int)$briquelist[$i]);
                $niveauexistlist = $briquesCompetencesNiveau->findBy(["fichescompetances"=> $fichesCompetence, "briquescompetances"=> $brique]);
                if (empty($niveauexistlist)) {
                    $niveau = new BriquesCompetencesNiveau();
                    $niveau->setFichescompetances($fichesCompetence);
                    $niveau->setBriquescompetances($brique);
                } else {
                    $niveau = $niveauexistlist[0];
                }
                $niveau->setNiveau((int)$niveaulist[$i]);
                $briquesCompetencesNiveau->add($niveau);
            }
            $niveaulistnouveau = $request->request->all("niveauvaovao");
            for ($i=0; $i < count($niveaulistnouveau); $i++) { 
                $briquelist = $briquesCompetencesRepository->findBy(["brq_comp_titre"=> $compettitrelist[$i]]);
                $brique = $briquelist[0];
                $niveauexistlist = $briquesCompetencesNiveau->findBy(["fichescompetances"=> $fichesCompetence, "briquescompetances"=> $brique]);
                if (empty($niveauexistlist)) {
                    $niveau = new BriquesCompetencesNiveau();
                    $niveau->setFichescompetances($fichesCompetence);
                    $niveau->setBriquescompetances($brique);
                } else {
                    $niveau = $niveauexistlist[0];
                }
                $niveau->setNiveau((int)$niveaulistnouveau[$i]);
                $briquesCompetencesNiveau->add($niveau);
            }
        }
        $data["fiche_competance"] = $fichesCompetencesRepository->findAll();
        $data["rome"] = [];
        $allRomes = $romeRepository->findAll();
        foreach ($allRomes as $rome) {
            $data["rome"][] = $rome->_toArray();
        }
        $data["fiche_competance_global"] = $competencesGlobalesRepository->findAll();
        return $this->json($data);
    }

    /**
     * @Route("/{id}", name="app_fiches_competences_show", methods={"GET"})
     */
    public function show(FichesCompetences $fichesCompetence): Response
    {
        return $this->render('fiches_competences/show.html.twig', [
            'fiches_competence' => $fichesCompetence,
        ]);
    }

    /**
     * @Route("/detail", name="app_fiches_competences_detail", methods={"GET", "POST"})
     */
    public function detail(Request $request, FichesCompetencesRepository $fichesCompetencesRepository): JsonResponse
    {
        return $this->json($fichesCompetencesRepository->find((int)$request->request->get("code")));
    }

    /**
     * @Route("/{id}/edit", name="app_fiches_competences_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, FichesCompetences $fichesCompetence, FichesCompetencesRepository $fichesCompetencesRepository): Response
    {
        $form = $this->createForm(FichesCompetencesType::class, $fichesCompetence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fichesCompetencesRepository->add($fichesCompetence);
            return $this->redirectToRoute('app_fiches_competences_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('fiches_competences/edit.html.twig', [
            'fiches_competence' => $fichesCompetence,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_fiches_competences_delete", methods={"POST"})
     */
    public function delete(Request $request, FichesCompetences $fichesCompetence, FichesCompetencesRepository $fichesCompetencesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fichesCompetence->getId(), $request->request->get('_token'))) {
            $fichesCompetencesRepository->remove($fichesCompetence);
        }

        return $this->redirectToRoute('app_fiches_competences_index', [], Response::HTTP_SEE_OTHER);
    }
}
