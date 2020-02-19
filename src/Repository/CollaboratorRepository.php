<?php

namespace App\Repository;

use App\Entity\Collaborator;
use App\Entity\CollaboratorSearch;
use App\Entity\PropertySearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Symfony\Component\Validator\Constraints\Collection;

/**
 * @method Collaborator|null find($id, $lockMode = null, $lockVersion = null)
 * @method Collaborator|null findOneBy(array $criteria, array $orderBy = null)
 * @method Collaborator[]    findAll()
 * @method Collaborator[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollaboratorRepository extends ServiceEntityRepository
{
    private $statusRepository;
    public function __construct(ManagerRegistry $registry,ActualStatusRepository $statusRepository)
    {
        parent::__construct($registry, Collaborator::class);
         $this->statusRepository=$statusRepository;
    }

   public  function  countTotal()
   {

       $qb = $this->createQueryBuilder('e');

       $qb ->select($qb->expr()->count('e'));

       return (int) $qb->getQuery()->getSingleScalarResult();
   }
    public  function  countTotalStatus()
    {

        $qb = $this->statusRepository->createQueryBuilder('e');

        $qb ->select($qb->expr()->count('e'));

        return (int) $qb->getQuery()->getSingleScalarResult();
    }
    public  function  totalAT()
    {

        return  $this->createQueryBuilder('c')

            ->andWhere('c.operating_mode=:test')
            ->setParameter('test',1)
        ->getQuery()
        ->getResult();
    }

    public  function  totalForfait()
    {

        return  $this->createQueryBuilder('c')

            ->andWhere('c.operating_mode=:test')
            ->setParameter('test',2)
            ->getQuery()
            ->getResult();
    }
    public  function  totalByStatus()
    {
        $tot=1;
        $statusList=array();
        for($i=1;$i < ($this->countTotalStatus())+1;$i++)
        {
           /* $statusName = $this->statusRepository->createQueryBuilder('s')
                ->addSelect('s.name')
                ->andwhere('s.id =:idd')
                ->setParameter('idd', 1)
                ->getQuery()
                ->getResult();*/

            $test = $this->createQueryBuilder('c')
                ->andWhere('c.actualStatus=:test')
                ->setParameter('test', $i);
            $tot= (int)count($test->getQuery()->getResult());
          $statusList[$i]=$tot;

        }
        return $statusList;
    }

    public function findLatest():array
    {

        return $this->findVisibleQuery()

            ->setMaxResults(4)
            ->getQuery()
            ->getResult();;


    }
    public function findAllVisible(CollaboratorSearch $search):Query
    {
        $query= $this->findVisibleQuery();
        if($search->getActualStatus())
        {
            $taster=$search->getActualStatus();
            $query=$query
                ->andWhere('c.actualStatus=:taster')
                ->setParameter('taster',$taster);

        }
        if($search->getOperatingMode())
        {
            $test=$search->getOperatingMode();
            $query=$query
                ->andWhere('c.operating_mode=:test')
                ->setParameter('test',$test);

        }

        if($search->getClients()->count() > 0)
        { $k=0;
            foreach ($search->getClients() as $client)
            {
                $k++;
                $query=$query
                    ->andWhere(":client$k MEMBER OF c.clients")
                    ->setParameter("client$k",$client);
            }

        }
        return $query->getQuery();

    }
    // /**
    //  * @return Collaborator[] Returns an array of Collaborator objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Collaborator
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    private function findVisibleQuery()
    {
        return $this->createQueryBuilder('c')
           /* ->where('c.id > 0')*/
            ->orderBy('c.id','desc')
            ;
    }
}
