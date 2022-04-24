<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use League\OAuth2\Client\Provider\GithubResourceOwner;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

//    public  function  UpdateFromOauth(GithubResourceOwner $owner): User{
//        $user = $this->findBy()
//    }
    public  function  findOrCreateFromOauth(GithubResourceOwner $owner): User{
        $user = $this->createQueryBuilder('u')
            ->where('u.email = :email')
            ->setParameters([
                'email' => $owner->getEmail()
            ])
            ->getQuery()
            ->getOneOrNullResult();
        if ($user){
            return $user;
        }
        $user = (new User())

            ->setEmail($owner->getEmail())
            ->setNom($owner->getNickname());

            $em = $this->getEntityManager();
        $em->persist($user);
        $em->flush();
        return  $user;
    }


    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
