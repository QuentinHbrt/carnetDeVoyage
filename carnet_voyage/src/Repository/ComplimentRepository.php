<?php

namespace App\Repository;

use App\Entity\Compliment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Compliment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Compliment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Compliment[]    findAll()
 * @method Compliment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComplimentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Compliment::class);
    }

    // /**
    //  * @return Compliment[] Returns an array of Compliment objects
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
    public function findOneBySomeField($value): ?Compliment
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
