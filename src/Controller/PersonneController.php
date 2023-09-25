<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\PersonneType;
use App\Repository\PersonneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EntrepriseRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Compte;
use App\Repository\CompteRepository;
use App\Entity\Accreditation;
use App\Repository\AccreditationRepository;
/**
 * @Route("/personne")
 */
class PersonneController extends AbstractController
{
    /**
     * @Route("/", name="app_personne_index", methods={"POST"})
     */
    public function index(Request $request, EntrepriseRepository $entrepriseRepository, PersonneRepository $personneRepository): JsonResponse
    {
        $entreprise = $entrepriseRepository->find((int)$request->request->get("entrepriseid"));
        $data["personnelist"] = $personneRepository->findBy(["entreprise"=> $entreprise]);
        return $this->json($data);
    }

    /**
     * @Route("/new", name="app_personne_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PersonneRepository $personneRepository, EntrepriseRepository $entrepriseRepository, CompteRepository $compteRepository, AccreditationRepository $accreditationRepository): JsonResponse
    {
        $entreprise = $entrepriseRepository->find((int)$request->request->get("entrepriseid"));
        $personne = new Personne();
        $personne->setPersonneNom($request->request->get("nom"));
        $personne->setPersonnePrenom($request->request->get("prenom"));
        $personne->setPersonneEmail($request->request->get("email"));
        $personne->setPersonneTelephone($request->request->get("telephone"));
        $personne->setPersonneAdresse($request->request->get("adresse"));
        $personne->setPersonneGenre((int)$request->request->get("genre"));
        $date = date("Y-m-d", strtotime($request->request->get("date_naissance")));
        $personne->setPersonneDateNaissance(new \DateTime($date));
        $personne->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
        $personne->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
        if ($request->request->get("creeuncompte") === "ok") {
            $compte = new Compte();
            $compte->setCompteNom($request->request->get("nom"));
            $compte->setComptePrenom($request->request->get("prenom"));
            $compte->setCompteEmail($request->request->get("email"));
            $compte->setCompteTelephone($request->request->get("telephone"));
            $compte->setCompteMotDePasse($request->request->get("password"));
            $compte->setCompteRole($request->request->get("role"));
            $compte->setCompteService($request->request->get("service"));
            $compte->setCompteNomUtilisateur($request->request->get("email"));
            $compte->setCompteEntrepriseId($entreprise);
            $compte->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
            $compte->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
            $compteRepository->add($compte);
            $personne->setPersonneCompte($compte);
        }
        $accreditation = new Accreditation();
        $accreditation->setAccreTitre($request->request->get("acretitre"));
        $accreditation->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
        $accreditation->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
        $accreditationRepository->add($accreditation);
        $personne->addPersonneAccreditation($accreditation);
        $personne->setEntreprise($entreprise);
        $personneRepository->add($personne);
        $data["personnelist"] = $personneRepository->findBy(["entreprise"=> $entreprise]);
        return $this->json($data);
    }

    /**
     * @Route("/{id}", name="app_personne_show", methods={"GET"})
     */
    public function show(Personne $personne): Response
    {
        return $this->render('personne/show.html.twig', [
            'personne' => $personne,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_personne_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Personne $personne, PersonneRepository $personneRepository): Response
    {
        $form = $this->createForm(PersonneType::class, $personne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personneRepository->add($personne);
            return $this->redirectToRoute('app_personne_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('personne/edit.html.twig', [
            'personne' => $personne,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_personne_delete", methods={"POST"})
     */
    public function delete(Request $request, Personne $personne, PersonneRepository $personneRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$personne->getId(), $request->request->get('_token'))) {
            $personneRepository->remove($personne);
        }

        return $this->redirectToRoute('app_personne_index', [], Response::HTTP_SEE_OTHER);
    }
}
