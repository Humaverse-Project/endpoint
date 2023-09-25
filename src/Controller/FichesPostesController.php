<?php

namespace App\Controller;

use App\Entity\FichesPostes;
use App\Form\FichesPostesType;
use App\Repository\FichesCompetencesRepository;
use App\Repository\FichesPostesRepository;
use App\Repository\RomeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

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
     * @Route("/new", name="app_fiches_postes_new", methods={"GET", "POST"})
     */
    public function new(Request $request, FichesPostesRepository $fichesPostesRepository, RomeRepository $romeRepository, FichesCompetencesRepository $fichesCompetencesRepository): Response
    {
        $fichesPoste = new FichesPostes();
        $competance = $fichesCompetencesRepository->find((int)$request->request->get("competanceid"));
        $rome = $romeRepository->find((int)$request->request->get("metierid"));
        $fichesPoste->setConditionsGenerales($request->request->get("condition_general"));
        $fichesPoste->setFichesPostesAgrement($request->request->get("agrement"));
        $fichesPoste->setFichesPostesDefinition([$request->request->get("definition")]);
        $fichesPoste->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
        $fichesPoste->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
        $fichesPoste->setFichesPostesFicheRome($rome);
        $fichesPoste->setFichesPostesActivite([$request->request->get("activite")]);
        $fichesPoste->setInstructions([$request->request->get("instruction")]);
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
     * @Route("/{id}", name="app_fiches_postes_show", methods={"GET"})
     */
    public function show(FichesPostes $fichesPoste): Response
    {
        return $this->render('fiches_postes/show.html.twig', [
            'fiches_poste' => $fichesPoste,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_fiches_postes_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, FichesPostes $fichesPoste, FichesPostesRepository $fichesPostesRepository): Response
    {
        $form = $this->createForm(FichesPostesType::class, $fichesPoste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fichesPostesRepository->add($fichesPoste);
            return $this->redirectToRoute('app_fiches_postes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('fiches_postes/edit.html.twig', [
            'fiches_poste' => $fichesPoste,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_fiches_postes_delete", methods={"POST"})
     */
    public function delete(Request $request, FichesPostes $fichesPoste, FichesPostesRepository $fichesPostesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fichesPoste->getId(), $request->request->get('_token'))) {
            $fichesPostesRepository->remove($fichesPoste);
        }

        return $this->redirectToRoute('app_fiches_postes_index', [], Response::HTTP_SEE_OTHER);
    }
}
