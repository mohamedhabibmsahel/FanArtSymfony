<?php

namespace App\Repository;

use App\Entity\Recevent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Recevent|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recevent|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recevent[]    findAll()
 * @method Recevent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReceventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recevent::class);
    }

    /**
    * @return Recevent[] Returns an array of Recevent objects
    */

    public function findByEmail($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.email = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Recevent
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
