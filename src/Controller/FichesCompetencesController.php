<?php

namespace App\Controller;

use App\Entity\FichesCompetences;
use App\Entity\Accreditation;
use App\Entity\BriquesCompetencesNiveau;
use App\Form\FichesCompetencesType;
use App\Repository\FichesCompetencesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\AccreditationRepository;
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
    public function index(FichesCompetencesRepository $fichesCompetencesRepository, RomeRepository $romeRepository): JsonResponse
    {
        $allRomes = $romeRepository->findAll();
        $data["rome"] = [];
        foreach ($allRomes as $rome) {
            $data["rome"][] = $rome->_toArray();
        }
        $data["fiche_competance"] = $fichesCompetencesRepository->findAll();
        return $this->json($data);
    }

    /**
     * @Route("/new", name="app_fiches_competences_new", methods={"GET", "POST"})
     */
    public function new(Request $request, FichesCompetencesRepository $fichesCompetencesRepository, AccreditationRepository $accreditationRepository, BriquesCompetencesRepository $briquesCompetencesRepository, BriquesCompetencesNiveauRepository $briquesCompetencesNiveau, RomeRepository $romeRepository, EmploiRepository $emploiRepository): JsonResponse
    {
        $emplois = $emploiRepository->find((int)$request->request->get("emploisid"));
        if ($emplois) {
            $actuel = $fichesCompetencesRepository->findBy(["appelation"=>$emplois], ['id' => 'DESC']);
            $version = 1.0;
            if (!empty($actuel)) {
                $actuel = $actuel[0];
                $version = (float)$actuel->getFicCompVersion()+0.1;
            }
            $acreditation = $accreditationRepository->find((int)$request->request->get("accreid"));
            if (!$acreditation) {
                $acreditation = new Accreditation();
                $acreditation->setAccreTitre($request->request->get("accretitre"));
                $acreditation->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
                $acreditation->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
                $accreditationRepository->add($acreditation);
            }
            $fichesCompetence = new FichesCompetences();
            $fichesCompetence->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
            $fichesCompetence->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
            $fichesCompetence->setFicCompTitreEmploi($request->request->get("titre"));
            $fichesCompetence->setFicCompVersion($version);
            $fichesCompetence->setAppelation($emplois);
            $fichesCompetence->setFicCompAccreditations($acreditation);
            $briquelist = $request->request->all("brique");
            $niveaulist = $request->request->all("niveau");
            for ($i=0; $i < count($briquelist); $i++) { 
                $brique = $briquesCompetencesRepository->find($briquelist[$i]);
                $fichesCompetence->addFicCompCompetence($brique);
            }
            $fichesCompetencesRepository->add($fichesCompetence);
            for ($i=0; $i < count($niveaulist); $i++) { 
                $brique = $briquesCompetencesRepository->find((int)$briquelist[$i]);
                $niveau = new BriquesCompetencesNiveau();
                $niveau->setNiveau((int)$niveaulist[$i]);
                $niveau->setFichescompetances($fichesCompetence);
                $niveau->setBriquescompetances($brique);
                $briquesCompetencesNiveau->add($niveau);
            }
        }
        
        $data["fiche_competance"] = $fichesCompetencesRepository->findAll();
        $data["rome"] = [];
        $allRomes = $romeRepository->findAll();
        foreach ($allRomes as $rome) {
            $data["rome"][] = $rome->_toArray();
        }
        // $data["compglobal"] = $competencesGlobalesRepository->findAll();
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
