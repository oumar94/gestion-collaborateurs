<?php

namespace App\Controller;

use App\Entity\ActualStatus;
use App\Form\ActualStatusType;
use App\Repository\ActualStatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/actual/status")
 */
class ActualStatusController extends AbstractController
{
    /**
     * @Route("/", name="actual_status_index", methods={"GET"})
     */
    public function index(ActualStatusRepository $actualStatusRepository): Response
    {
        return $this->render('actual_status/index.html.twig', [
            'actual_statuses' => $actualStatusRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="actual_status_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $actualStatus = new ActualStatus();
        $form = $this->createForm(ActualStatusType::class, $actualStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($actualStatus);
            $entityManager->flush();

            return $this->redirectToRoute('actual_status_index');
        }

        return $this->render('actual_status/new.html.twig', [
            'actual_status' => $actualStatus,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="actual_status_show", methods={"GET"})
     */
    public function show(ActualStatus $actualStatus): Response
    {
        return $this->render('actual_status/show.html.twig', [
            'actual_status' => $actualStatus,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="actual_status_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ActualStatus $actualStatus): Response
    {
        $form = $this->createForm(ActualStatusType::class, $actualStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('actual_status_index');
        }

        return $this->render('actual_status/edit.html.twig', [
            'actual_status' => $actualStatus,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="actual_status_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ActualStatus $actualStatus): Response
    {
        if ($this->isCsrfTokenValid('delete'.$actualStatus->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($actualStatus);
            $entityManager->flush();
        }

        return $this->redirectToRoute('actual_status_index');
    }
}
