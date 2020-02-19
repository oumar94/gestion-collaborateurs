<?php

namespace  App\Controller;

use App\Entity\CollaboratorSearch;
use App\Form\CollaboratorSearchType;
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
     * @var CollaboratorRepository
     */
    private $repository;
    /**
     * @var ActualStatusRepository
     */
    private $statusRepository;
    public function __construct(CollaboratorRepository $repository,ActualStatusRepository $statusRepository)
    {
        $this->repository=$repository;
        $this->statusRepository= $statusRepository;
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
    public function listAll(PaginatorInterface $paginator,Request $request): Response
    {
        $search=new CollaboratorSearch();
        $form= $this->createForm(CollaboratorSearchType::class,$search);
        $form->handleRequest($request);
        $collaborators=$paginator->paginate($this->repository->findAllVisible($search), $request->query->getInt('page', 1),30);
        $status=$this->statusRepository->findStatus();
        return $this->render('pages/collaborators.html.twig', [
            'collaborators' => $collaborators,
            'status'=>$status,
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/statistics", name="collaborator_statistics", methods={"GET"})
     * @param CollaboratorRepository $collaboratorRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function statistic(): Response
    {
        $totalTray=$this->repository->countTotal();
        $status=$this->statusRepository->findStatus();
        $totalByStatus=$this->repository->totalByStatus();

        $totalAT=$this->repository->totalAT();
        $totalForfait=$this->repository->totalForfait();
        return $this->render('pages/statistics.html.twig',[

            'totalTray'=>$totalTray,
            'totalAT'=>$totalAT,
            'totalForfait'=>$totalForfait,
            'totalByStatus'=>$totalByStatus
        ]);
    }
}