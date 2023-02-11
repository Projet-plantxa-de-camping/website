<?php

namespace App\Repository;

use App\Entity\CookingTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CookingTime|null find($id, $lockMode = null, $lockVersion = null)
 * @method CookingTime|null findOneBy(array $criteria, array $orderBy = null)
 * @method CookingTime[]    findAll()
 * @method CookingTime[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CookingTimeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CookingTime::class);
    }

    // /**
    //  * @return CookingTime[] Returns an array of CookingTime objects
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
    public function findOneBySomeField($value): ?CookingTime
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
