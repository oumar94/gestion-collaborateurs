<?php

namespace App\Repository;

use App\Entity\Collaborator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

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


    public function findLatest():array
    {

        return $this->findVisibleQuery()

            ->setMaxResults(4)
            ->getQuery()
            ->getResult();

    }
    public function findAllVisible():array
    {
        return $this->findVisibleQuery()
            ->getQuery()
            ->getResult();

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
            //->where('c.sold = false')
            ->orderBy('c.id','desc')
            ;
    }
}
