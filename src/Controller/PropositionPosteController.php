<?php

namespace App\Controller;

use App\Entity\PropositionPoste;
use App\Form\PropositionPosteType;
use App\Repository\PropositionPosteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/proposition/poste")
 */
class PropositionPosteController extends AbstractController
{
    /**
     * @Route("/", name="app_proposition_poste_index", methods={"GET"})
     */
    public function index(PropositionPosteRepository $propositionPosteRepository): Response
    {
        return $this->render('proposition_poste/index.html.twig', [
            'proposition_postes' => $propositionPosteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_proposition_poste_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PropositionPosteRepository $propositionPosteRepository): Response
    {
        $propositionPoste = new PropositionPoste();
        $form = $this->createForm(PropositionPosteType::class, $propositionPoste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $propositionPosteRepository->add($propositionPoste);
            return $this->redirectToRoute('app_proposition_poste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('proposition_poste/new.html.twig', [
            'proposition_poste' => $propositionPoste,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_proposition_poste_show", methods={"GET"})
     */
    public function show(PropositionPoste $propositionPoste): Response
    {
        return $this->render('proposition_poste/show.html.twig', [
            'proposition_poste' => $propositionPoste,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_proposition_poste_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, PropositionPoste $propositionPoste, PropositionPosteRepository $propositionPosteRepository): Response
    {
        $form = $this->createForm(PropositionPosteType::class, $propositionPoste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $propositionPosteRepository->add($propositionPoste);
            return $this->redirectToRoute('app_proposition_poste_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('proposition_poste/edit.html.twig', [
            'proposition_poste' => $propositionPoste,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_proposition_poste_delete", methods={"POST"})
     */
    public function delete(Request $request, PropositionPoste $propositionPoste, PropositionPosteRepository $propositionPosteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$propositionPoste->getId(), $request->request->get('_token'))) {
            $propositionPosteRepository->remove($propositionPoste);
        }

        return $this->redirectToRoute('app_proposition_poste_index', [], Response::HTTP_SEE_OTHER);
    }
}
