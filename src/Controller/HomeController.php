<?php

namespace  App\Controller;

use App\Repository\ActualStatusRepository;
use App\Repository\CollaboratorRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends  AbstractController
{

    /**
     * @var PropertyRepository
     */
    private $repository;
    public function __construct(CollaboratorRepository $repository)
    {
        $this->repository=$repository;
    }

    /**
     * @Route("/",name="home")
     * @param ActualStatusRepository $statusRepository
     * @return Response
     */
        public  function  index(ActualStatusRepository $statusRepository)
        {
            $collaborators=$this->repository->findLatest();
            $status=$statusRepository->findStatus();
            return $this->render('pages/home.html.twig',['collaborators'=>$collaborators,'status'=>$status]);
        }

    /**
     * @Route("/all", name="collaborator_list", methods={"GET"})
     * @param CollaboratorRepository $collaboratorRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function listAll(PaginatorInterface $paginator,Request $request,ActualStatusRepository $statusRepository): Response
    {

        $collaborators=$paginator->paginate($this->repository->findAllVisible(), $request->query->getInt('page', 1),8);
        $status=$statusRepository->findStatus();
        return $this->render('pages/collaborators.html.twig', [
            'collaborators' => $collaborators,
            'status'=>$status
        ]);
    }
}