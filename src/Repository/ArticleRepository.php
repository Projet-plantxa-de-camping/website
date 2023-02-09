<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function findByPriceRange($minValue, $maxValue)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.price >= :minVal')
            ->setParameter('minVal', $minValue)
            ->andWhere('a.price <= :maxVal')
            ->setParameter('maxVal', $maxValue)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findArticleByName($mot_cle){
        return $this->createQueryBuilder('a')
            ->where('a.name like :name')
            ->setParameter('name', '%'.$mot_cle.'%')
            ->orderBy('a.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

}
