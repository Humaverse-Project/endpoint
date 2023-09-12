<?php

namespace App\Controller;

use App\Entity\Rome;
use App\Form\RomeType;
use App\Repository\RomeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\ApiRequest\RomeInterface;
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
     * @Route("/synchrome", name="app_rome_synch", methods={"GET"})
     */
    public function synchrome(RomeRepository $romeRepository, RomeInterface $romeInterface)
    {
        $scope = "api_rome-metiersv1 nomenclatureRome";
        $access = $romeInterface->authetification($scope);
        $list = $romeInterface->getFicheMetierData($access["access_token"]);
        if (!empty($list)) {
            $romeRepository->batchinsert($list);
            $romelist = $romeRepository->findAll();
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
        $form = $this->createForm(RomeType::class, $rome);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $romeRepository->add($rome);
            return $this->redirectToRoute('app_rome_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rome/edit.html.twig', [
            'rome' => $rome,
            'form' => $form,
        ]);
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
