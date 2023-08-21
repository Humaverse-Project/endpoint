<?php

namespace App\Controller;

use App\Entity\VoteProposition;
use App\Form\VotePropositionType;
use App\Repository\VotePropositionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/vote/proposition")
 */
class VotePropositionController extends AbstractController
{
    /**
     * @Route("/", name="app_vote_proposition_index", methods={"GET"})
     */
    public function index(VotePropositionRepository $votePropositionRepository): JsonResponse
    {
        return $this->json($votePropositionRepository->findAll());
    }

    /**
     * @Route("/new", name="app_vote_proposition_new", methods={"GET", "POST"})
     */
    public function new(Request $request, VotePropositionRepository $votePropositionRepository): JsonResponse
    {
        $voteProposition = new VoteProposition();
        $votePropositionRepository->add($voteProposition);
        return $this->json($votePropositionRepository->findAll());
    }

    /**
     * @Route("/{id}/edit", name="app_vote_proposition_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, VoteProposition $voteProposition, VotePropositionRepository $votePropositionRepository): JsonResponse
    {
        $votePropositionRepository->add($voteProposition);
        return $this->json($votePropositionRepository->findAll());
    }

    /**
     * @Route("/{id}", name="app_vote_proposition_delete", methods={"POST"})
     */
    public function delete(Request $request, VoteProposition $voteProposition, VotePropositionRepository $votePropositionRepository): JsonResponse
    {
        $votePropositionRepository->remove($voteProposition);
        return $this->json($votePropositionRepository->findAll());
    }
}
