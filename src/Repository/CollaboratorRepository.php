<?php

namespace App\Repository;

use App\Entity\Collaborator;
use App\Entity\CollaboratorSearch;
use App\Entity\PropertySearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method Collaborator|null find($id, $lockMode = null, $lockVersion = null)
 * @method Collaborator|null findOneBy(array $criteria, array $orderBy = null)
 * @method Collaborator[]    findAll()
 * @method Collaborator[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollaboratorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Collaborator::class);
    }

   public  function  countTotal()
   {

       $qb = $this->createQueryBuilder('e');

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
    public function findLatest():array
    {

        return $this->findVisibleQuery()

            ->setMaxResults(4)
            ->getQuery();


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
