<?php

namespace App\Controller;

use App\Repository\CompteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/compte")
 */
class CompteController extends AbstractController
{
    /**
     * @Route("/authentification", name="app_compte_authentification", methods={"GET", "POST"})
     */
    public function authentification(Request $request, CompteRepository $compteRepository): JsonResponse
    {
        $data = $compteRepository->findBy(["compte_nom_utilisateur"=> $request->request->get("username"), "compte_mot_de_passe"=> $request->request->get("password")]);
        $result = ["error"=> true, "data"=>[]];
        if (!empty($data)) {
            $result = ["error"=>false, "data"=> $data];
        }
        return $this->json($result);
    }
}
