<?php

namespace App\Controller;

use App\Entity\ContextesTravail;
use App\Form\ContextesTravailType;
use App\Repository\ContextesTravailRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
