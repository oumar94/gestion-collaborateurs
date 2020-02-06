<?php

namespace App\Controller;

use App\Entity\Collaborator;
use App\Form\CollaboratorType;
use App\Repository\ActualStatusRepository;
use App\Repository\CollaboratorRepository;
use App\Repository\OperatingModeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/collaborator")
 */
class CollaboratorController extends AbstractController
{
    private $statusRepository;
    private  $modeRepository;
    public function __construct(ActualStatusRepository $statusRepository,OperatingModeRepository $modeRepository)
    {
        $this->statusRepository=$statusRepository;
        $this->modeRepository=$modeRepository;
    }

    /**
     * @Route("/admin", name="collaborator_index", methods={"GET"})
     */
    public function index(CollaboratorRepository $collaboratorRepository,PaginatorInterface $paginator,Request $request): Response
    {
        $collaborators=$paginator->paginate($collaboratorRepository->findAll(), $request->query->getInt('page', 1),6);
        $status=$this->statusRepository->findStatus();
        $modes=$this->modeRepository->findModes();
        return $this->render('collaborator/index.html.twig', [
            'collaborators' => $collaborators,
            'status'=>$status,
            'modes'=>$modes
        ]);
    }


    /**
     * @Route("/new", name="collaborator_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $collaborator = new Collaborator();
        $form = $this->createForm(CollaboratorType::class, $collaborator);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($collaborator);
            $entityManager->flush();

            return $this->redirectToRoute('collaborator_index');
        }

        return $this->render('collaborator/new.html.twig', [
            'collaborator' => $collaborator,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="collaborator_show", methods={"GET"})
     */
    public function show(Collaborator $collaborator): Response
    {
        return $this->render('collaborator/show.html.twig', [
            'collaborator' => $collaborator,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="collaborator_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Collaborator $collaborator): Response
    {
        $form = $this->createForm(CollaboratorType::class, $collaborator);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('collaborator_index');
        }

        return $this->render('collaborator/edit.html.twig', [
            'collaborator' => $collaborator,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="collaborator_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Collaborator $collaborator): Response
    {
        if ($this->isCsrfTokenValid('delete'.$collaborator->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($collaborator);
            $entityManager->flush();
        }

        return $this->redirectToRoute('collaborator_index');
    }
}
