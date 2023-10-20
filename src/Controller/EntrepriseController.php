<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Entity\Compte;
use App\Repository\EntrepriseRepository;
use App\Repository\CompteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Services\ApiRequest\SiretInterface;
/**
 * @Route("/entreprise")
 */
class EntrepriseController extends AbstractController
{
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
        $validationemail = $compteRepository->findBy(["compte_nom_utilisateur"=> $request->request->get("emailrh")]);
        if (!empty($validationemail)) {
            return $this->json(["stat"=>false, "message"=> "Adresse email existe déjà"]);
        }
        $compte = new Compte();
        $compte->setCompteEmail($request->request->get("emailrh"));
        $compte->setCompteTelephone($request->request->get("telephonerh"));
        $compte->setCompteService($request->request->get("servicerh"));
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
     * @Route("/sirettoken", name="app_entreprise_sirettoken", methods={"GET"})
     */
    public function synchrome(SiretInterface $siretInterface): JsonResponse{
        return $this->json($siretInterface->authetification());
    }
}
