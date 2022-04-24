<?php

namespace App\Repository;

use App\Entity\Salle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Salle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Salle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Salle[]    findAll()
 * @method Salle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Salle::class);
    }

    public function trierNumsalleASC()
    {
        return $this->createQueryBuilder('salle')
            ->orderBy('salle.numsalle','ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function trierNumsalleDESC()
    {
        return $this->createQueryBuilder('salle')
            ->orderBy('salle.numsalle','DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function showAllByNumsalle($nom){
        return $this->createQueryBuilder('salle')
            ->where('salle.numsalle LIKE :numsalle')
            ->setParameter('numsalle', '%'.$nom.'%')
            ->getQuery()
            ->getResult();
    }
    // /**
    //  * @return Salle[] Returns an array of Salle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Salle
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

