<?php

namespace App\Controller;

use App\Entity\VoteProposition;
use App\Form\VotePropositionType;
use App\Repository\VotePropositionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/vote/proposition")
 */
class VotePropositionController extends AbstractController
{
    /**
     * @Route("/", name="app_vote_proposition_index", methods={"GET"})
     */
    public function index(VotePropositionRepository $votePropositionRepository): Response
    {
        return $this->render('vote_proposition/index.html.twig', [
            'vote_propositions' => $votePropositionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_vote_proposition_new", methods={"GET", "POST"})
     */
    public function new(Request $request, VotePropositionRepository $votePropositionRepository): Response
    {
        $voteProposition = new VoteProposition();
        $form = $this->createForm(VotePropositionType::class, $voteProposition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $votePropositionRepository->add($voteProposition);
            return $this->redirectToRoute('app_vote_proposition_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vote_proposition/new.html.twig', [
            'vote_proposition' => $voteProposition,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_vote_proposition_show", methods={"GET"})
     */
    public function show(VoteProposition $voteProposition): Response
    {
        return $this->render('vote_proposition/show.html.twig', [
            'vote_proposition' => $voteProposition,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_vote_proposition_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, VoteProposition $voteProposition, VotePropositionRepository $votePropositionRepository): Response
    {
        $form = $this->createForm(VotePropositionType::class, $voteProposition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $votePropositionRepository->add($voteProposition);
            return $this->redirectToRoute('app_vote_proposition_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vote_proposition/edit.html.twig', [
            'vote_proposition' => $voteProposition,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_vote_proposition_delete", methods={"POST"})
     */
    public function delete(Request $request, VoteProposition $voteProposition, VotePropositionRepository $votePropositionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$voteProposition->getId(), $request->request->get('_token'))) {
            $votePropositionRepository->remove($voteProposition);
        }

        return $this->redirectToRoute('app_vote_proposition_index', [], Response::HTTP_SEE_OTHER);
    }
}
