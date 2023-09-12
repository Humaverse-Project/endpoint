<?php

namespace App\Controller;

use App\Entity\ContextesTravail;
use App\Entity\BriquesContexte;
use App\Form\ContextesTravailType;
use App\Repository\ContextesTravailRepository;
use App\Repository\BriquesContexteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\ApiRequest\RomeInterface;
use App\Repository\RomeRepository;
/**
 * @Route("/contextes/travail")
 */
class ContextesTravailController extends AbstractController
{
    /**
     * @Route("/", name="app_contextes_travail_index", methods={"GET"})
     */
    public function index(ContextesTravailRepository $contextesTravailRepository): Response
    {
        return $this->render('contextes_travail/index.html.twig', [
            'contextes_travails' => $contextesTravailRepository->findAll(),
        ]);
    }
    /**
     * @Route("/synchrome", name="app_contextes_travail_synchrome", methods={"GET"})
     */
    public function synchrome(RomeRepository $romeRepository, RomeInterface $romeInterface, ContextesTravailRepository $contextesTravailRepository, BriquesContexteRepository $briquesContexteRepository)
    {
        set_time_limit(500);
        $scope = "nomenclatureRome api_rome-metiersv1";
        $access = $romeInterface->authetification($scope);
        $romemetierlist = $romeRepository->findAll();
        $i = 0;
        $contextesTravail = $contextesTravailRepository->findAll();
        foreach ($romemetierlist as $metier) {
            if ($i % 100 == 0) {
                $access = $romeInterface->authetification($scope);
            }
            sleep(1);
            $data = $romeInterface->getFicheMetierMetierDatainformation($access["access_token"], $metier->getRomeCoderome());
            $resultats = array_map(function($valeur) {
                $data = new ContextesTravail;
                $data->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
                $data->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
                $data->setCtxTrvTitre($valeur["categorie"]);
                return $data;
            }, $data["contextesTravail"]);
            $uniqueValues = [];
            $resultats = array_values(array_filter($resultats, function ($item) use (&$uniqueValues) {
                if (!isset($uniqueValues[$item->getCtxTrvTitre()])) {
                    $uniqueValues[$item->getCtxTrvTitre()] = true;
                    return true;
                }
                return false;
            }));
            for ($i=0; $i < count($resultats); $i++) {
                $key = $resultats[$i];
                $contextr = array_filter($contextesTravail, function ($entiteRome) use ($key) {
                    return ($entiteRome->getCtxTrvTitre() === $key->getCtxTrvTitre());
                });
                if (empty($contextr)) {
                    $contextesTravailRepository->add($key);
                }
            }
            $contextesTravail = $contextesTravailRepository->findAll();
            $resultatsbrique = array_map(function($valeur) use ($metier, $contextesTravail) {
                $contextr = array_filter($contextesTravail, function ($entiteRome) use ($valeur) {
                    return ($entiteRome->getCtxTrvTitre() === $valeur["categorie"]);
                });
                $data = new BriquesContexte;
                $data->setBrqCtxTitre($valeur["libelle"]);
                $data->setUpdatedAt(new \DateTimeImmutable('@'.strtotime('now')));
                $data->setCreatedAt(new \DateTimeImmutable('@'.strtotime('now')));
                $data->setRome($metier);
                if (!empty($contextr)) {
                    rsort($contextr);
                    $data->setContexte($contextr[0]);
                }
                return $data;
            }, $data["contextesTravail"]);
            for ($i=0; $i < count($resultatsbrique); $i++) { 
                $briquesContexteRepository->add($resultatsbrique[$i]);
            }
            $i = $i+1;
        }
        dd("terminer");
    }
    /**
     * @Route("/new", name="app_contextes_travail_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ContextesTravailRepository $contextesTravailRepository): Response
    {
        $contextesTravail = new ContextesTravail();
        $form = $this->createForm(ContextesTravailType::class, $contextesTravail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contextesTravailRepository->add($contextesTravail);
            return $this->redirectToRoute('app_contextes_travail_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contextes_travail/new.html.twig', [
            'contextes_travail' => $contextesTravail,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_contextes_travail_show", methods={"GET"})
     */
    public function show(ContextesTravail $contextesTravail): Response
    {
        return $this->render('contextes_travail/show.html.twig', [
            'contextes_travail' => $contextesTravail,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_contextes_travail_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ContextesTravail $contextesTravail, ContextesTravailRepository $contextesTravailRepository): Response
    {
        $form = $this->createForm(ContextesTravailType::class, $contextesTravail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contextesTravailRepository->add($contextesTravail);
            return $this->redirectToRoute('app_contextes_travail_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('contextes_travail/edit.html.twig', [
            'contextes_travail' => $contextesTravail,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_contextes_travail_delete", methods={"POST"})
     */
    public function delete(Request $request, ContextesTravail $contextesTravail, ContextesTravailRepository $contextesTravailRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contextesTravail->getId(), $request->request->get('_token'))) {
            $contextesTravailRepository->remove($contextesTravail);
        }

        return $this->redirectToRoute('app_contextes_travail_index', [], Response::HTTP_SEE_OTHER);
    }
}
