<?php

namespace App\Controller;

use App\Entity\BriquesCompetences;
use App\Entity\Rome;
use App\Form\RomeType;
use App\Repository\BriquesCompetencesRepository;
use App\Repository\BriquesContexteRepository;
use App\Repository\EmploiRepository;
use App\Repository\RomeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\ApiRequest\RomeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/rome")
 */
class RomeController extends AbstractController
{
    /**
     * @Route("/", name="app_rome_index", methods={"GET"})
     */
    public function index(RomeRepository $romeRepository): Response
    {
        return $this->render('rome/index.html.twig', [
            'romes' => $romeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/list", name="app_rome_list", methods={"GET"})
     */
    public function list(RomeRepository $romeRepository): JsonResponse
    {
        $allRomes = $romeRepository->findAll();

        $formattedData = [];
        foreach ($allRomes as $rome) {
            $formattedData[] = $rome->_toArray();
        }

        return new JsonResponse($formattedData);
    }

    /**
     * @Route("/detail", name="app_rome_detail", methods={"POST"})
     */
    public function detail( Request $request, RomeRepository $romeRepository, EmploiRepository $emploiRepository, BriquesCompetencesRepository $briquesCompetencesRepository, BriquesContexteRepository $briquesContexteRepository ): JsonResponse
    {
        $rome = $romeRepository->findBy(["rome_coderome"=> $request->request->get("code")]);
        $data["rome"] = $rome[0]->_toArray();
        $data["appelation"] = $emploiRepository->findBy(["rome"=> $rome[0]]);
        $data["briquecompetance"] = $briquesCompetencesRepository->findBy(["rome"=> $rome[0]]);
        $data["briquecontexte"] = $briquesContexteRepository->findBy(["rome"=> $rome[0]]);
        return $this->json($data);
    }

    /**
     * @Route("/synchrome", name="app_rome_synch", methods={"GET"})
     */
    public function synchrome(RomeRepository $romeRepository, RomeInterface $romeInterface)
    {
        $scope = "api_rome-metiersv1 nomenclatureRome";
        $access = $romeInterface->authetification($scope);
        $list = $romeInterface->getFicheMetierData($access["access_token"]);
        if (!empty($list)) {
            $romelist = $romeRepository->findAll();
            if (!empty($romelist)) {
                dd("rome déjà synchroniser");
            } else {
                $romeRepository->batchinsert($list);
                $romelist = $romeRepository->findAll();
            }
            $projectDir = $this->getParameter('kernel.project_dir')."/public/unix_rubrique_mobilite_v451_utf8.csv";
            $result = $romeInterface->getFicheMetierDataLier($projectDir);
            foreach ($result as $key => $value) {
                $rome = array_filter($romelist, function ($entiteRome) use ($key) {
                    return $entiteRome->getRomeCoderome() === $key;
                });
                rsort($rome);
                for ($i=0; $i < count($value); $i++) { 
                    $romecible = $value[$i]["code_rome_cible"];
                    $romemobil = array_filter($romelist, function ($entiteRome) use ($romecible) {
                        return $entiteRome->getRomeCoderome() === $romecible;
                    });
                    rsort($romemobil);
                    if (!empty($rome) and !empty($romemobil)) {
                        if ($value[$i]["code_type_mobilite"] == 2) {
                            $rome[0]->addFichesRomeEvolution($romemobil[0]);
                        } else {
                            $rome[0]->addFichesRomeProch($romemobil[0]);
                        }
                    }
                }
                if (!empty($rome)){
                    $romeRepository->add($rome[0]);
                }
            }
            $romelist = $romeRepository->findAll();
            dd($romelist);
        } else {
            dd("erreur connexion pôle emplois");
        }
        
    }

    /**
     * @Route("/new", name="app_rome_new", methods={"GET", "POST"})
     */
    public function new(Request $request, RomeRepository $romeRepository): Response
    {
        $rome = new Rome();
        $form = $this->createForm(RomeType::class, $rome);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $romeRepository->add($rome);
            return $this->redirectToRoute('app_rome_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rome/new.html.twig', [
            'rome' => $rome,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_rome_show", methods={"GET"})
     */
    public function show(Rome $rome): Response
    {
        return $this->render('rome/show.html.twig', [
            'rome' => $rome,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_rome_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Rome $rome, RomeRepository $romeRepository): Response
    {
        $rome->setRomeAccesMetier($request->request->get("rome_acces_metier"));
        $rome->setRomeDefinition($request->request->get("rome_definition"));
        $rome->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
        $rome->setRomeTitre($request->request->get("nom"));
        $romeRepository->add($rome);
        return $this->redirectToRoute('app_rome_list', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}", name="app_rome_delete", methods={"POST"})
     */
    public function delete(Request $request, Rome $rome, RomeRepository $romeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rome->getId(), $request->request->get('_token'))) {
            $romeRepository->remove($rome);
        }

        return $this->redirectToRoute('app_rome_index', [], Response::HTTP_SEE_OTHER);
    }
}
