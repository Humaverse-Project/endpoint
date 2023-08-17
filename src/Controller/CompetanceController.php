<?php

namespace App\Controller;

use App\Entity\Competance;
use App\Form\CompetanceType;
use App\Repository\CompetanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/competance")
 */
class CompetanceController extends AbstractController
{
    /**
     * @Route("/", name="app_competance_index", methods={"GET"})
     */
    public function index(CompetanceRepository $competanceRepository): Response
    {
        return $this->render('competance/index.html.twig', [
            'competances' => $competanceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_competance_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CompetanceRepository $competanceRepository): Response
    {
        $competance = new Competance();
        $form = $this->createForm(CompetanceType::class, $competance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $competanceRepository->add($competance);
            return $this->redirectToRoute('app_competance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('competance/new.html.twig', [
            'competance' => $competance,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_competance_show", methods={"GET"})
     */
    public function show(Competance $competance): Response
    {
        return $this->render('competance/show.html.twig', [
            'competance' => $competance,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_competance_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Competance $competance, CompetanceRepository $competanceRepository): Response
    {
        $form = $this->createForm(CompetanceType::class, $competance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $competanceRepository->add($competance);
            return $this->redirectToRoute('app_competance_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('competance/edit.html.twig', [
            'competance' => $competance,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_competance_delete", methods={"POST"})
     */
    public function delete(Request $request, Competance $competance, CompetanceRepository $competanceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$competance->getId(), $request->request->get('_token'))) {
            $competanceRepository->remove($competance);
        }

        return $this->redirectToRoute('app_competance_index', [], Response::HTTP_SEE_OTHER);
    }
}
