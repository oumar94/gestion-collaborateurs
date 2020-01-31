<?php

namespace App\Repository;

use App\Entity\ActualStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ActualStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActualStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActualStatus[]    findAll()
 * @method ActualStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActualStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActualStatus::class);
    }

    public function findStatus():array
    {

        return $this->createQueryBuilder('c')

            ->orderBy('c.id','desc')
            ->getQuery()
            ->getResult();

    }

    // /**
    //  * @return ActualStatus[] Returns an array of ActualStatus objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ActualStatus
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
