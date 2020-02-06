<?php

namespace App\Repository;

use App\Entity\OperatingMode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method OperatingMode|null find($id, $lockMode = null, $lockVersion = null)
 * @method OperatingMode|null findOneBy(array $criteria, array $orderBy = null)
 * @method OperatingMode[]    findAll()
 * @method OperatingMode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OperatingModeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OperatingMode::class);
    }

    public function  findModes()
    {
        return $this->createQueryBuilder('mode')

            ->orderBy('mode.id','desc')
            ->getQuery()
            ->getResult();

    }

    // /**
    //  * @return OperatingMode[] Returns an array of OperatingMode objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OperatingMode
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
