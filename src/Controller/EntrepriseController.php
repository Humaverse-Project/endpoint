<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Entity\Compte;
use App\Form\EntrepriseType;
use App\Repository\EntrepriseRepository;
use App\Repository\CompteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/entreprise")
 */
class EntrepriseController extends AbstractController
{
    /**
     * @Route("/", name="app_entreprise_index", methods={"GET"})
     */
    public function index(EntrepriseRepository $entrepriseRepository): Response
    {
        return $this->render('entreprise/index.html.twig', [
            'entreprises' => $entrepriseRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_entreprise_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntrepriseRepository $entrepriseRepository, CompteRepository $compteRepository): JsonResponse
    {
        $entreprise = new Entreprise();
        $entreprise->setEntrepriseAdresse($request->request->get("rue_numero"));
        $entreprise->setEntrepriseApeNaf($request->request->get("naf"));
        $entreprise->setEntrepriseCodePostal($request->request->get("code_postal"));
        $entreprise->setEntrepriseNom($request->request->get("nom_entreprise"));
        $entreprise->setEntrepriseEffectif($request->request->get("effectif"));
        $entreprise->setEntrepriseEmail($request->request->get("email"));
        $entreprise->setEntrepriseEtablissement((int)$request->request->get("etablissement"));
        $entreprise->setEntrepriseUrl($request->request->get("url"));
        $entreprise->setEntreprisePays($request->request->get("pays"));
        $entreprise->setEntrepriseSiret($request->request->get("siret"));
        $entreprise->setEntrepriseTelephone($request->request->get("telephone"));
        $entreprise->setEntrepriseVille($request->request->get("ville"));
        $entreprise->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
        $entreprise->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
        $entrepriseRepository->add($entreprise);
        $compte = new Compte();
        $compte->setCompteEmail($request->request->get("emailrh"));
        $compte->setCompteMotDePasse($request->request->get("password"));
        $compte->setCompteEntrepriseId($entreprise);
        $compte->setCompteNomUtilisateur($request->request->get("emailrh"));
        $compte->setComptePrenom($request->request->get("prenomrh"));
        $compte->setCompteNom($request->request->get("nomrh"));
        $compte->setCompteRole($request->request->get("fonctionrh"));
        $compte->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
        $compte->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
        $compteRepository->add($compte);
        return $this->json(["stat"=>true]);
    }

    /**
     * @Route("/{id}", name="app_entreprise_show", methods={"GET"})
     */
    public function show(Entreprise $entreprise): Response
    {
        return $this->render('entreprise/show.html.twig', [
            'entreprise' => $entreprise,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_entreprise_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Entreprise $entreprise, EntrepriseRepository $entrepriseRepository): Response
    {
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entrepriseRepository->add($entreprise);
            return $this->redirectToRoute('app_entreprise_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('entreprise/edit.html.twig', [
            'entreprise' => $entreprise,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_entreprise_delete", methods={"POST"})
     */
    public function delete(Request $request, Entreprise $entreprise, EntrepriseRepository $entrepriseRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entreprise->getId(), $request->request->get('_token'))) {
            $entrepriseRepository->remove($entreprise);
        }

        return $this->redirectToRoute('app_entreprise_index', [], Response::HTTP_SEE_OTHER);
    }
}
