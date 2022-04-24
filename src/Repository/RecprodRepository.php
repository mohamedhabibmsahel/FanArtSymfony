<?php

namespace App\Repository;

use App\Entity\Recprod;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Recprod|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recprod|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recprod[]    findAll()
 * @method Recprod[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecprodRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recprod::class);
    }

     /**
      * @return Recprod[] Returns an array of Recprod objects
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
    public function findOneBySomeField($value): ?Recprod
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
