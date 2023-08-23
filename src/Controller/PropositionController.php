<?php

namespace App\Controller;

use App\Entity\Proposition;
use App\Repository\PropositionRepository;
use App\Entity\PropositionPoste;
use App\Repository\PropositionPosteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CompetanceRepository;
use App\Repository\MetierRepository;
use App\Entity\VoteProposition;
use App\Repository\VotePropositionRepository;

/**
 * @Route("/proposition")
 */
class PropositionController extends AbstractController
{
    /**
     * @Route("/", name="app_proposition_index", methods={"GET"})
     */
    public function index(PropositionRepository $propositionRepository): JsonResponse
    {
        return $this->json($propositionRepository->findAll());
    }

    /**
     * @Route("/new", name="app_proposition_new", methods={"POST"})
     */
    public function new(Request $request, PropositionRepository $propositionRepository,
    CompetanceRepository $competanceRepository,
    MetierRepository $metierRepository, PropositionPosteRepository $propositionPosteRepository): JsonResponse
    {
        $proposition = new Proposition();
        $proposition->setCreation(new \DateTime('@'.strtotime('now')));
        $proposition->setCreatedby(1);
        $listdatacompetanceid = $request->request->all("competanceid");
        $listdatametierid = $request->request->all("metier_id");
        $niveauCompetance = $request->request->all("niveauCompetance");
        $typeCompetance = $request->request->all("type");
        $exidlist = $request->request->all("id");
        $propositionRepository->add($proposition);
        $metier = $metierRepository->find((int)$listdatametierid[0]);
        for ($i=0; $i < count($listdatacompetanceid); $i++) { 
            $competance = $competanceRepository->find((int)$listdatacompetanceid[$i]);
            $poste = new PropositionPoste();
            $poste->setCompetance($competance);
            $poste->setMetier($metier);
            $poste->setCreatedby(1);
            $poste->setCreation(new \DateTime('@'.strtotime('now')));
            if($typeCompetance[$i] == "update"){
                $poste->setExId($exidlist[$i]);
            }
            $poste->setNiveauCompetance((int)$niveauCompetance[$i]);
            $poste->setType($typeCompetance[$i]);
            $poste->setProposition($proposition);
            $propositionPosteRepository->add($poste);
        }
        return $this->json($propositionRepository->findAll());
    }

    /**
     * @Route("/update", name="app_proposition_edit", methods={"GET", "POST"})
     */
    public function update(Request $request, PropositionRepository $propositionRepository,
    CompetanceRepository $competanceRepository,
    MetierRepository $metierRepository, PropositionPosteRepository $propositionPosteRepository): JsonResponse
    {
        $id_propositionlist = $request->request->all("id_proposition");
        $proposition = $propositionRepository->find((int)$id_propositionlist[0]);
        $listdatacompetanceid = $request->request->all("competanceid");
        $listdatametierid = $request->request->all("metier_id");
        $niveauCompetance = $request->request->all("niveauCompetance");
        $typeCompetance = $request->request->all("type2");
        $metier = $metierRepository->find((int)$listdatametierid[0]);
        $exidlist = $request->request->all("id");
        for ($i=0; $i < count($listdatacompetanceid); $i++) { 
            $competance = $competanceRepository->find((int)$listdatacompetanceid[$i]);
            if($typeCompetance[$i] == "new"){
                $poste = new PropositionPoste();
                $poste->setCreatedby(1);
                $poste->setCreation(new \DateTime('@'.strtotime('now')));
                $poste->setMetier($metier);
                $poste->setType($typeCompetance[$i]);
                $poste->setProposition($proposition);
            } else {
                $poste = $propositionPosteRepository->find((int)$exidlist[$i]);
            }
            $poste->setCompetance($competance);
            $poste->setNiveauCompetance((int)$niveauCompetance[$i]);
            $propositionPosteRepository->add($poste);
        }
        return $this->json($propositionRepository->findAll());
    }

    /**
     * @Route("/vote", name="app_proposition_vote_save", methods={"POST"})
     */
    public function vote(Request $request, PropositionRepository $propositionRepository, VotePropositionRepository $votePropositionRepository): JsonResponse
    {
        $votevalue = $request->request->get("value");
        $vote_id = $request->request->get("vote_id");
        if ($vote_id === "null") {
            $vote_id = NULL;
        } else {
            $vote_id = (int)$vote_id;
        }
        if ($votevalue === "null") {
            $votevalue = NULL;
        } elseif ($votevalue === "true") {
            $votevalue = true;
        } elseif ($votevalue === "false") {
            $votevalue = false;
        }
        $propositionid = $request->request->get("id");
        $proposition = $propositionRepository->find((int)$propositionid);
        if (is_null($vote_id) and !is_null($votevalue)) {
            $vote = new VoteProposition();
            $vote->setCreation(new \DateTime('@'.strtotime('now')));
            $vote->setProposition($proposition);
            $vote->setValue($votevalue);
            $vote->setVotepar(1);
            $votePropositionRepository->add($vote);
        } elseif (!is_null($vote_id) and !is_null($votevalue)) {
            $vote = $votePropositionRepository->find((int)$vote_id);
            $vote->setValue($votevalue);
            $votePropositionRepository->add($vote);
        } elseif (is_null($votevalue) and !is_null($vote_id)) {
            $vote = $votePropositionRepository->find((int)$vote_id);
            $votePropositionRepository->remove($vote);
        } else {
            dd($votevalue, $vote_id);
        }
        return $this->json($propositionRepository->findAll());
    }

    /**
     * @Route("/{id}", name="app_proposition_delete", methods={"POST"})
     */
    public function delete(Request $request, Proposition $proposition, PropositionRepository $propositionRepository): JsonResponse
    {
        $propositionRepository->remove($proposition);
        return $this->json($propositionRepository->findAll());
    }
}
