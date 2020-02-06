<?php

namespace App\Controller;

use App\Entity\OperatingMode;
use App\Form\OperatingModeType;
use App\Repository\OperatingModeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/operating/mode")
 */
class OperatingModeController extends AbstractController
{
    /**
     * @Route("/", name="operating_mode_index", methods={"GET"})
     */
    public function index(OperatingModeRepository $operatingModeRepository): Response
    {
        return $this->render('operating_mode/index.html.twig', [
            'operating_modes' => $operatingModeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="operating_mode_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $operatingMode = new OperatingMode();
        $form = $this->createForm(OperatingModeType::class, $operatingMode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($operatingMode);
            $entityManager->flush();

            return $this->redirectToRoute('operating_mode_index');
        }

        return $this->render('operating_mode/new.html.twig', [
            'operating_mode' => $operatingMode,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="operating_mode_show", methods={"GET"})
     */
    public function show(OperatingMode $operatingMode): Response
    {
        return $this->render('operating_mode/show.html.twig', [
            'operating_mode' => $operatingMode,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="operating_mode_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, OperatingMode $operatingMode): Response
    {
        $form = $this->createForm(OperatingModeType::class, $operatingMode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('operating_mode_index');
        }

        return $this->render('operating_mode/edit.html.twig', [
            'operating_mode' => $operatingMode,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="operating_mode_delete", methods={"DELETE"})
     */
    public function delete(Request $request, OperatingMode $operatingMode): Response
    {
        if ($this->isCsrfTokenValid('delete'.$operatingMode->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($operatingMode);
            $entityManager->flush();
        }

        return $this->redirectToRoute('operating_mode_index');
    }
}
